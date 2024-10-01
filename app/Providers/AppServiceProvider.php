<?php

namespace Inmanturbo\Signal\Providers;

use Illuminate\Support\ServiceProvider;
use Inmanturbo\Signal\Console\Commands\SignalConfigureCommand;
use Inmanturbo\Signal\Console\Commands\SignalMigrateCommand;
use Inmanturbo\Signal\Signal;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/signal.php', 'signal'
        );

        $this->app->scoped(Signal::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/signal.php' => config_path('signal.php'),
        ]);

        $this->publishesMigrations([
            __DIR__.'/../../database/migrations' => database_path('migrations/signal'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                SignalMigrateCommand::class,
                SignalConfigureCommand::class,
            ]);
        }
    }
}
