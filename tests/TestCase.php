<?php

namespace Inmanturbo\Signal\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Inmanturbo\Signal\SignalServiceProvider;
use Spatie\EventSourcing\EventSourcingServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Inmanturbo\\Signal\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SignalServiceProvider::class,
            EventSourcingServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');


        $migration = include __DIR__.'/../vendor/spatie/laravel-event-sourcing/database/migrations/create_snapshots_table.php.stub';
        $migration->up();

        $migration = include __DIR__.'/../vendor/spatie/laravel-event-sourcing/database/migrations/create_stored_events_table.php.stub';
        $migration->up();
    }
}
