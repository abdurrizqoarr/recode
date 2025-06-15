<?php

namespace App\Filament\Exports;

use App\Models\PendidikanFormal;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PendidikanFormalExporter extends Exporter
{
    protected static ?string $model = PendidikanFormal::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('pegawai.name')
                ->label('Nama'),
            ExportColumn::make('pegawai.aum.namaAum')
                ->label('Asal AUM'),
            ExportColumn::make('tingkatPendidikan')
                ->label('Tingkat Pendidikan'),
            ExportColumn::make('lembagaPendidikan')
                ->label('Lembaga Pendidikan'),
            ExportColumn::make('tahunLulus')
                ->label('Tahun Lulus'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your pendidikan formal export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
