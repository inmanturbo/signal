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
        $this->app->singleton(CommandBus::class);
    }
}
