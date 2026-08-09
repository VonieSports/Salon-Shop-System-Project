<?php

namespace App\Providers;

use App\Services\BlockUserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->singleton(BlockUserService::class, function ($app) {
            return new BlockUserService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(
            ['layouts.salon_owner', 'layouts.salon_owner.header', 'layouts.salon_owner.sidebar'],
            function ($view) {
                static $tenant = null;
                static $resolved = false;

                if (!$resolved) {
                    $tenant = Auth::user()?->tenant()
                    ->select(['id', 'name', 'email', 'logo', 'business_setup_completed', 'verification_status', 'rejection_reason'])
                    ->first();
                    $resolved = true;
                }

            $view->with('tenant', $tenant);
        }
    );
    }
}
