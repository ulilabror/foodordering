<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Filament\Facades\Filament; 
use Filament\Support\Assets\Js;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;


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

 FilamentAsset::register([
            // CSS
            Css::make('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'),
            
            // JavaScript
            Js::make('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'),
            
            // Optional: Custom JS Anda
            Js::make('map-init', asset('js/map-init.js')),
        ]);
        Livewire::listen('basketUpdated', function () {
            // Perbarui badge navigasi
            Filament::refreshNavigation();
        });
    }
}
