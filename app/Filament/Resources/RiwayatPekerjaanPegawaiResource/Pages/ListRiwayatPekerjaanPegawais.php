<?php

namespace App\Filament\Resources\RiwayatPekerjaanPegawaiResource\Pages;

use App\Filament\Resources\RiwayatPekerjaanPegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPekerjaanPegawais extends ListRecords
{
    protected static string $resource = RiwayatPekerjaanPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
