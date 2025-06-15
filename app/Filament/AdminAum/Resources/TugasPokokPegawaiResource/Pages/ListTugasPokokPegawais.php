<?php

namespace App\Filament\AdminAum\Resources\TugasPokokPegawaiResource\Pages;

use App\Filament\AdminAum\Resources\TugasPokokPegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTugasPokokPegawais extends ListRecords
{
    protected static string $resource = TugasPokokPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
