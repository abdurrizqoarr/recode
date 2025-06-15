<?php

namespace App\Filament\AdminAum\Resources\RiwayatPekerjaanPegawaiResource\Pages;

use App\Filament\AdminAum\Resources\RiwayatPekerjaanPegawaiResource;
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
