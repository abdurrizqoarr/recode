<?php

namespace App\Filament\Exports;

use App\Models\TugasPokok;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TugasPokokExporter extends Exporter
{
    protected static ?string $model = TugasPokok::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('pegawai.name')
                ->label('Nama'),
            ExportColumn::make('pegawai.aum.namaAum')
                ->label('Asal AUM'),
            ExportColumn::make('tugasPokok'),
            ExportColumn::make('namaAum'),
            ExportColumn::make('nomerAum'),
            ExportColumn::make('namaPenandatangan'),
            ExportColumn::make('jabatanPenandaTangan'),
            ExportColumn::make('nomerSK'),
            ExportColumn::make('tanggalSK'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your tugas pokok export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
