<?php

namespace App\Providers\Filament;

use App\Filament\Pegawai\Pages\LoginPegawai;
use App\Filament\Pegawai\Pages\Profile;
use App\Filament\Pegawai\Pages\TugasPokok;
use App\Filament\Pegawai\Pages\UserSetting;
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

class PegawaiPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('pegawai')
            ->path('pegawai')
            ->favicon(asset('images/logo.png'))
            ->brandName('SIMDIK AUM KUTIM')
            ->login(LoginPegawai::class)
            ->colors([
                'primary' => '#0e7490',
            ])
            ->authGuard('pegawais')
            ->discoverResources(in: app_path('Filament/Pegawai/Resources'), for: 'App\\Filament\\Pegawai\\Resources')
            ->discoverPages(in: app_path('Filament/Pegawai/Pages'), for: 'App\\Filament\\Pegawai\\Pages')
            ->pages([
                Profile::class,
                TugasPokok::class,
                UserSetting::class
            ])
            ->discoverWidgets(in: app_path('Filament/Pegawai/Widgets'), for: 'App\\Filament\\Pegawai\\Widgets')
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
