<?php

namespace App\Filament\Widgets;

use App\Models\Profile;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountProfilePegawai extends BaseWidget
{
    protected int | string | array $columnSpan = "3";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $pegawai = Profile::count();

        return [
            Stat::make('Jumlah_Profile', $pegawai)
                ->description('Total Profile Pegawai yang terdaftar')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->label('Profile'),
        ];
    }
}
