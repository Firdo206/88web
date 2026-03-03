<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Daftarkan Blade anonymous components
        Blade::component('components.styles',     'styles');
        Blade::component('layouts.admin',          'admin-layout');
        Blade::component('layouts.user',           'user-layout');
    }
}