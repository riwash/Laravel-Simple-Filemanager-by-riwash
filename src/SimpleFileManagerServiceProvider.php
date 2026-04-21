<?php

namespace Riwash\SimpleFileManager;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Riwash\SimpleFileManager\Components\FileUploader;

class SimpleFileManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'simple-file-manager');

        // Register Blade component using view path directly
        Blade::component(FileUploader::class, 'fileupload');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Publish all assets, views, and config in one tag
        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/simple-file-manager'),
            __DIR__ . '/resources/views' => resource_path('views/vendor/simple-file-manager'),
            __DIR__ . '/config/riwashfilemanager.php' => config_path('riwashfilemanager.php'),
        ], 'simple-file-manager');
    }

    public function register()
    {
        // Merge package config with application's config
        $this->mergeConfigFrom(
            __DIR__ . '/config/riwashfilemanager.php',
            'riwashfilemanager',
        );
    }
}
