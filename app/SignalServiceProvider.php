<?php

namespace Inmanturbo\Signal;

use Inmanturbo\Signal\Commands\SignalCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasViews();
        foreach (glob($this->migrationPath().'/*') as $file) {
            $package->hasMigration(pathinfo($file, PATHINFO_FILENAME));
        }

        $package
            ->hasCommand(SignalCommand::class);
    }

    public function registeringPackage(): void
    {
        $this->setConfigs();

        $this->app->singleton(CommandBus::class);
    }

    protected function setConfigs(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-data'.DIRECTORY_SEPARATOR.'event-sourcing.php',
            'signal.event-sourcing'
        );

        config(['event-sourcing' => array_merge((array) config('event-sourcing', []), (array) config('signal.event-sourcing', []))]);
    }

    protected function migrationPath(): string
    {
        return __DIR__.'/../database/migrations';
    }
}
