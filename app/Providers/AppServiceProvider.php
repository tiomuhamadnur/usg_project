<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
        Blade::directive('currency', function ( $expression ) { return "Rp. <?php echo number_format($expression,0,',','.'); ?>"; });

        Blade::if('superAdmin', function () {
            return Auth::user()->role_id == 1;
        });

        Blade::if('Admin', function () {
            return in_array(Auth::user()->role_id, [1 , 2]);
        });

        Blade::if('Dokter', function () {
            return in_array(Auth::user()->role_id, [1 , 3]);
        });

        Blade::if('Suster', function () {
            return in_array(Auth::user()->role_id, [1, 3, 4]);
        });

        Blade::if('Kasir', function () {
            return in_array(Auth::user()->role_id, [1 , 5]);
        });
    }
}
