<?php

namespace App\Filament\Widgets;

use App\Models\PegawaiAum;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountUserPegawai extends BaseWidget
{
    protected int | string | array $columnSpan = "3";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $pegawai = PegawaiAum::count();

        return [
            Stat::make('Jumlah_User', $pegawai)
                ->description('Total User Pegawai yang terdaftar')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->label('User'),
        ];
    }
}
