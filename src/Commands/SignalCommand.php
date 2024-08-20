<?php

namespace Inmanturbo\Signal\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Support\Facades\Schema;

class SignalCommand extends Command
{
    public $signature = 'signal:migrate 
        {--force : Run the command without asking for confirmation} 
        {--fresh : Drop all signal tables and re-run migrations} 
        {--database= : The database connection to use} 
        {--reset : Rollback all signal migrations} 
        {--log-only : Log the migration in the database without running it} 
        {--wipe : Drop all signal tables and delete all migrations}
        {--path= : The path to the migrations files to be executed}
        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
        {--tables=* : A list of tables to drop before running the migrations}
        {--drop-only : Drop the tables without running the migrations}
        {--delete-only : Delete the migrations without running them}';

    public $description = 'Run the signal migrations';

    protected MigrationRepositoryInterface $repository;

    public function handle(): int
    {
        $this->repository = app('migration.repository');

        if ($this->option('database')) {
            app(DatabaseManager::class)
                ->usingConnection($this->option('database'), fn () => $this->body());

            return self::SUCCESS;
        }

        $this->body();

        return self::SUCCESS;
    }

    protected function tables(): array
    {
        $defaultTables = array_merge(
            config('signal.migration_tables', []),
            [
                config('verbs.tables.events', 'verbs_events'),
                config('verbs.tables.snapshots', 'verbs_snapshots'),
                config('verbs.tables.state_events', 'verbs_state_events'),
            ]);

        return $this->option('tables') ?: $defaultTables;
    }

    protected function migrationPath(): string
    {
        return $this->option('path') ?: realpath(__DIR__.'/../../database/migrations');
    }

    protected function dropTables(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ($this->tables() as $table) {
            $this->info("Dropping table: $table");
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();
    }

    protected function deleteMigrations(): void
    {
        foreach (glob($this->migrationPath().'/*') as $file) {
            $migration = (object) ['migration' => pathinfo($file, PATHINFO_FILENAME)];
            $this->info("Deleting migration: $migration->migration");
            $this->repository->delete($migration);
        }
    }

    protected function fresh(): void
    {
        $this->dropTables();

        $this->deleteMigrations();
    }

    protected function logMigration(string $file): void
    {
        $batch = 0;

        $this->info("Logging migration: $file");

        $this->repository->log($file, $batch);
    }

    protected function logMigrations(): void
    {
        foreach (glob($this->migrationPath().'/*') as $file) {
            $this->logMigration(pathinfo($file, PATHINFO_FILENAME));
        }
    }

    protected function body()
    {
        if ($this->option('delete-only')) {
            $this->deleteMigrations();

            return;
        }

        if ($this->option('drop-only')) {
            $this->dropTables();

            return;
        }

        if ($this->option('log-only')) {
            $this->logMigrations();

            return;
        }

        if ($this->option('wipe')) {
            $this->fresh();

            return;
        }

        if ($this->option('fresh')) {
            $this->fresh();
        }

        $path = $this->migrationPath();

        $options = ['--path' => $path];

        if (! $this->option('path')) {
            $options['--realpath'] = true;
        }

        if ($this->option('path') && $this->option('realpath')) {
            $options['--realpath'] = true;
        }

        if ($this->option('force')) {
            $options['--force'] = true;
        }
        if ($this->option('reset')) {
            $this->call('migrate:reset', $options);
        }

        $this->call('migrate', $options);
    }
}
