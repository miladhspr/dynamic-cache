<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
use App\Services\CustomCacheManager;
use App\Services\Drivers\Database\DatabaseCacheDriver;
use App\Services\Drivers\File\FileCacheDriver;
use App\Services\Drivers\Redis\RedisCacheDriver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton('custom-cache', function ($app) {
            $driver = $app['config']['cache.default']; // Correct way to access config here
            return match ($driver) {
                'redis' => new CustomCacheManager(new RedisCacheDriver()),
                'database' => new CustomCacheManager(new DatabaseCacheDriver()),
                default => new CustomCacheManager(new FileCacheDriver()),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Post::observe(PostObserver::class);
    }
}
