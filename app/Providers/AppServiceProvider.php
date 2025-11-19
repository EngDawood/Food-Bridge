<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MatchingService;
use App\Services\NotificationService;
use App\Services\ReportService;
use App\Contracts\Services\ReportServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register services as singletons
        $this->app->singleton(NotificationService::class, function ($app) {
            return new NotificationService();
        });

        $this->app->singleton(MatchingService::class, function ($app) {
            return new MatchingService($app->make(NotificationService::class));
        });

        $this->app->bind(ReportServiceInterface::class, ReportService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
