<?php

namespace App\Filament\AdminAum\Widgets;

use App\Models\Profile;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class CountProfilePegawai extends BaseWidget
{
    protected int | string | array $columnSpan = "4";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $idAum = Auth::guard('admin-aums')->user()->id_aum;
        $pegawai = Profile::whereHas('pegawaiAum', function ($query) use ($idAum) {
            $query->where('id_aum', $idAum);
        })->count();

        return [
            Stat::make('Jumlah_Profile', $pegawai)
                ->description('Total Profile Pegawai yang terdaftar')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->label('Profile'),
        ];
    }
}
