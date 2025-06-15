<?php

namespace App\Filament\Widgets;

use App\Models\AdminAum;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountAdmin extends BaseWidget
{
    protected int | string | array $columnSpan = "3";

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getStats(): array
    {
        $admin = AdminAum::count();

        return [
            Stat::make('Jumlah_Admin_AUM', $admin)
                ->description('Total Admin AUM yang terdaftar')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->label('ADMIN AUM'),
        ];
    }
}
