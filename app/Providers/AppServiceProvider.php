<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        try {
            if (Schema::hasTable('settings')) {
                $settings = (object) Cache::rememberForever('app_settings', function () {
                    return Setting::pluck('value', 'key')->toArray();
                });
    
                View::share('settings', $settings);
            }
        } catch (\Exception $e) {
            Log::error('Error loading app settings: ' . $e->getMessage());
        }
    }
}
