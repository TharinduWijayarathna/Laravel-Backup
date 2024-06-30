<?php

namespace YourNamespace\LaravelBackup;

use Illuminate\Support\ServiceProvider;

class BackupServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            Commands\BackupCommand::class,
        ]);
    }

    public function boot()
    {
        //
    }
}
