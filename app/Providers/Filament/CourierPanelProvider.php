<?php

namespace App\Providers\Filament;


use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use App\Filament\Courier\Resources\DeliveryResource;
use App\Filament\Courier\Resources\CourierResource;

class CourierPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('courier')
            ->path('courier')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->registration()
            ->login()
            ->profile()
            ->brandName('Mie Gacor Courier')
            ->discoverResources(in: app_path('Filament/Courier/Resources'), for: 'App\\Filament\\Courier\\Resources')
            ->discoverPages(in: app_path('Filament/Courier/Pages'), for: 'App\\Filament\\Courier\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Courier/Widgets'), for: 'App\\Filament\\Courier\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->profile()
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups(array_filter([
                    auth()->user()?->courier
                        ? null: NavigationGroup::make('Registrasi Kurir')
                        // ->icon('heroicon-o-user')
                        ->items([
                            ...CourierResource::getNavigationItems(),
                        ]) ,
                    NavigationGroup::make('registration courier')
                        // ->icon('heroicon-o-book-open')
                        ->items([
                            ...CourierResource::getNavigationItems(),
                            // ...CategoryResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Jobs')
                        // ->icon('heroicon-o-truck')
                        ->items([
                            ...DeliveryResource::getNavigationItems(),
                            // ...CourierResource::getNavigationItems(),
                        ]),
                ]));
            })
            ->authMiddleware([
                Authenticate::class,
                // RedirectToProperPanelMiddleware::class,
            ]);
    }
}
