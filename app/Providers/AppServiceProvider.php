<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\CommissionSite;

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
        // Default Laravel pagination uses Tailwind styles; no override needed

        // Inject total commissions on all admin views by default
        View::composer('admin.*', function ($view) {
            try {
                $totalCommissions = CommissionSite::sum('montant_commission');
            } catch (\Throwable $e) {
                $totalCommissions = 0;
            }
            $view->with('totalCommissions', $totalCommissions);
        });
    }
}
