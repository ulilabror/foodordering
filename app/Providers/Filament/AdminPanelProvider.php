<?php

namespace App\Providers\Filament;

use App\Filament\Resources\CategoryResource;
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
use App\Filament\Resources\MenuResource;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderItemResource;
use App\Filament\Resources\DeliveryResource;
use App\Filament\Resources\CourierResource;
use App\Filament\Resources\UserResource;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('Mie Gacor Admin')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->login()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ->authMiddleware([
                Authenticate::class,
                // RedirectToProperPanelMiddleware::class,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make('Manajemen Menu')
                        // ->icon('heroicon-o-book-open')
                        ->items([
                            ...MenuResource::getNavigationItems(),
                            ...CategoryResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Manajemen Pesanan')
                        // ->icon('heroicon-o-receipt-refund')
                        ->items([
                            ...OrderResource::getNavigationItems(),
                            ...OrderItemResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Pengiriman')
                        // ->icon('heroicon-o-truck')
                        ->items([
                            ...DeliveryResource::getNavigationItems(),
                            ...CourierResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Pengguna')
                        // ->icon('heroicon-o-user-group')
                        ->items([
                            ...UserResource::getNavigationItems(),
                        ]),
                ]);
            });
    }
}
