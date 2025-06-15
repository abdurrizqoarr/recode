<?php

namespace App\Filament\AdminAum\Resources\RiwayatPekerjaanPegawaiResource\Pages;

use App\Filament\AdminAum\Resources\RiwayatPekerjaanPegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPekerjaanPegawai extends EditRecord
{
    protected static string $resource = RiwayatPekerjaanPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
