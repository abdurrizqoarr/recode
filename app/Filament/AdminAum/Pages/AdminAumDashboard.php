<?php

namespace App\Filament\AdminAum\Pages;

use App\Filament\AdminAum\Widgets\AumWidget;
use App\Filament\AdminAum\Widgets\CountProfilePegawai;
use App\Filament\AdminAum\Widgets\CountProfilePerStatus;
use App\Filament\AdminAum\Widgets\CountUserPegawai;
use Filament\Pages\Page;

class AdminAumDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.admin-aum.pages.admin-aum-dashboard';

    public function getHeaderWidgetsColumns(): int
    {
        return 12;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AumWidget::class,
            CountUserPegawai::class,
            CountProfilePegawai::class,
            CountProfilePerStatus::class
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
}
