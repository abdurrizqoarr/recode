<?php

namespace App\Providers\Filament;

use App\Filament\AdminAum\Pages\LoginAdminAum;
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

class AdminAumPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('adminAum')
            ->path('admin-aum')
            ->favicon(asset('images/logo.png'))
            ->brandName('SIMDIK AUM KUTIM')
            ->login(LoginAdminAum::class)
            ->colors([
                'primary' => '#0e7490',
            ])
            ->databaseNotifications(true)
            ->authGuard('admin-aums')
            ->discoverResources(in: app_path('Filament/AdminAum/Resources'), for: 'App\\Filament\\AdminAum\\Resources')
            ->discoverPages(in: app_path('Filament/AdminAum/Pages'), for: 'App\\Filament\\AdminAum\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/AdminAum/Widgets'), for: 'App\\Filament\\AdminAum\\Widgets')
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
            ]);
    }
}
