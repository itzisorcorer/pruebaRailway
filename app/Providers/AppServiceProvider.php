<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
                // 👇 Pega esta línea. Fuerza a que todas las URLs generadas sean HTTPS.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
