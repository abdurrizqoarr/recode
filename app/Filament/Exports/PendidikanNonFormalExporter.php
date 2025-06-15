<?php

namespace App\Filament\Exports;

use App\Models\PendidikanNonFormal;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PendidikanNonFormalExporter extends Exporter
{
    protected static ?string $model = PendidikanNonFormal::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('pegawai.name')
                ->label('Nama'),
            ExportColumn::make('pegawai.aum.namaAum')
                ->label('Asal AUM'),
            ExportColumn::make('lembagaPenyelenggara')
                ->label('Lembaga Penyelenggata'),
            ExportColumn::make('namaKursus')
                ->label('Nama Kursus'),
            ExportColumn::make('tingkat')
                ->label('Tingkat'),
            ExportColumn::make('tahunLulus')
                ->label('Tahun Lulus'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your pendidikan non formal export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
