<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define rate limiting for notifications
        RateLimiter::for('notifications', function ($job) {
            return Limit::perMinute(100); // 100 notifications per minute
        });

        // Optional: Define different limits for different queues
        RateLimiter::for('emails', function ($job) {
            return Limit::perMinute(60); // 60 emails per minute
        });
    }
}