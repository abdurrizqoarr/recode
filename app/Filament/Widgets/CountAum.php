<?php

namespace App\Filament\Widgets;

use App\Models\AdminAum;
use App\Models\Aum;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountAum extends BaseWidget
{
    protected int | string | array $columnSpan = "3";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $aum = Aum::count();

        return [
            Stat::make('Jumlah_AUM', $aum)
                ->description('Total AUM yang terdaftar')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->label('AUM'),
        ];
    }
}
