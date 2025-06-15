<?php

namespace App\Filament\Pegawai\Resources\TugasTambahanResource\Pages;

use App\Filament\Pegawai\Resources\TugasTambahanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTugasTambahans extends ListRecords
{
    protected static string $resource = TugasTambahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
