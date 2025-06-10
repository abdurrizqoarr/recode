<?php

namespace App\Filament\Exports;

use App\Models\Aum;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AumExporter extends Exporter
{
    protected static ?string $model = Aum::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('namaAum'),
            ExportColumn::make('npsm'),
            ExportColumn::make('alamatAum'),
            ExportColumn::make('teleponAum'),
            ExportColumn::make('emailAum'),
            ExportColumn::make('websiteAum'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your aum export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
