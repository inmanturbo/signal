<?php

namespace Inmanturbo\Signal;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Inmanturbo\Signal\Commands\SignalCommand;

class SignalServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('signal')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_signal_table')
            ->hasCommand(SignalCommand::class);
    }

    public function registeringPackage()
    {
        $this->setConfigs();

        $this->app->singleton(CommandBus::class);
    }

    protected function setConfigs(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-data' . DIRECTORY_SEPARATOR . 'event-sourcing.php',
            'signal.event-sourcing'
        );


        config(['event-sourcing' => array_merge(config('event-sourcing') ?? [], config('signal.event-sourcing'))]);
    }
}
