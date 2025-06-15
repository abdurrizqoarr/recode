<?php

namespace App\Filament\Exports;

use App\Models\RiwayatPekerjaan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RiwayatPekerjaanExporter extends Exporter
{
    protected static ?string $model = RiwayatPekerjaan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('pegawai.name')
                ->label('Nama'),
            ExportColumn::make('pegawai.aum.namaAum')
                ->label('Asal AUM'),
            ExportColumn::make('namaAum')
                ->label('Nama AUM'),
            ExportColumn::make('nomerAum')
                ->label('Nomer AUM'),
            ExportColumn::make('namaPenandatangan')
                ->label('Nama Penandatanga'),
            ExportColumn::make('jabatanPenandaTangan')
                ->label('Jabatan Penanda Tangan'),
            ExportColumn::make('tanggalSK')
                ->label('Tanggal Mulai SK'),
            ExportColumn::make('nomerSK')
                ->label('Nomer SK'),
            ExportColumn::make('masaKerjaDalamBulan')
                ->label('Masa Kerja Dalam Bulan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your riwayat pekerjaan export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
