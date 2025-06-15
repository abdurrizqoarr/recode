<?php

namespace App\Filament\AdminAum\Widgets;

use App\Models\Aum;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class AumWidget extends BaseWidget
{
    protected int | string | array $columnSpan = "4";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $idAum = Auth::guard('admin-aums')->user()->id_aum;
        $aum = Aum::where('id', $idAum)->first();

        return [
            Stat::make('namaAum', $aum->namaAum)
                ->icon('heroicon-s-share')
                ->color('primary')
                ->label('Admin AUM'),
        ];
    }
}
