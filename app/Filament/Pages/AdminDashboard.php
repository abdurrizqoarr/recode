<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CountAdmin;
use App\Filament\Widgets\CountAum;
use App\Filament\Widgets\CountProfilePegawai;
use App\Filament\Widgets\CountProfilePerStatus;
use App\Filament\Widgets\CountUserPegawai;
use App\Filament\Widgets\RekapJumlahPegawai;
use App\Models\AdminAum;
use Filament\Pages\Page;

class AdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.admin-dashboard';

    public function getHeaderWidgetsColumns(): int
    {
        return 12;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CountAum::class,
            CountAdmin::class,
            CountUserPegawai::class,
            CountProfilePegawai::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            RekapJumlahPegawai::class,
            CountProfilePerStatus::class,
        ];
    }
}
