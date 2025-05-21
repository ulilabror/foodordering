<?php

namespace App\Providers\Filament;


use App\Filament\Courier\Resources\OrderResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Pages\Dashboard;
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
use Filament\Navigation\NavigationItem;
use App\Filament\Courier\Resources\DeliveryResource;
use App\Filament\Courier\Resources\CourierResource;
use App\Filament\Courier\Resources\CourierResource\Widgets\TotalEarning;
use App\Filament\Courier\Resources\CourierResource\Widgets\TotalJobDelivered;
use App\Filament\Courier\Resources\CourierResource\Widgets\LastDeliveryStatus;

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
                Dashboard::class
            ])
            ->discoverWidgets(in: app_path('Filament/Courier/Widgets'), for: 'App\\Filament\\Courier\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                TotalEarning::class,
                TotalJobDelivered::class,
                LastDeliveryStatus::class,
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
                   NavigationGroup::make('Dashboard')
            ->items([
                NavigationItem::make('Dashboard')
                    ->label('Dashboard')
                    ->icon('heroicon-o-home')
                    ->url(Dashboard::getUrl()), //  arahkan ke halaman Dashboard
            ]),
                    auth()->user()?->courier
                    ? null : NavigationGroup::make('Registrasi Kurir')
                        // ->icon('heroicon-o-user')
                        ->items([
                            ...CourierResource::getNavigationItems(),
                        ]),
                    auth()->user()?->courier
                    ? NavigationGroup::make('Menu')
                        // ->icon('heroicon-o-truck')
                        ->items([
                            ...DeliveryResource::getNavigationItems(),
                            ...OrderResource::getNavigationItems(),
                            // ...CourierResource::getNavigationItems(),
                        ]) : null,
                    // NavigationGroup::make('')
                ]));
            })
            ->authMiddleware([
                Authenticate::class,
                // RedirectToProperPanelMiddleware::class,
            ]);
    }
}
