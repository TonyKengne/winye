<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

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
        // Charger les préférences depuis la DB ou config
    $language = Setting::where('key', 'language')->value('value') ?? 'fr';
    $theme    = Setting::where('key', 'theme')->value('value') ?? 'light';

    // Appliquer la langue
    App::setLocale($language);

    // Partager le thème avec toutes les vues
    View::share('theme', $theme);

        Schema::defaultStringLength(191);
    }
}


