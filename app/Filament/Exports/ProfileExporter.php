<?php

namespace App\Filament\Exports;

use App\Models\Profile;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProfileExporter extends Exporter
{
    protected static ?string $model = Profile::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('pegawaiAum.name')
                ->label('Nama'),
            ExportColumn::make('pegawaiAum.aum.namaAum')
                ->label('Asal AUM'),
            ExportColumn::make('noKTAM')
                ->label('No KTAM'),
            ExportColumn::make('noKTP')
                ->label('No KTP'),
            ExportColumn::make('noNIPY')
                ->label('No NIPY'),
            ExportColumn::make('tempatLahir')
                ->label('Tempat Lahir'),
            ExportColumn::make('jenisKelamin')
                ->label('Jenis Kelamin'),
            ExportColumn::make('tanggalLahir')
                ->label('Tanggal Lahir'),
            ExportColumn::make('isMarried')
                ->label('Sudah Menikah'),
            ExportColumn::make('alamat')
                ->label('Alamat'),
            ExportColumn::make('noTelp')
                ->label('No Telpon'),
            ExportColumn::make('totalMasaKerja')
                ->label('Total Masa Kerja'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your profile export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
