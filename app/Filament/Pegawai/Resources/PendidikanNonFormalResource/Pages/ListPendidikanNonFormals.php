<?php

namespace App\Filament\Pegawai\Resources\PendidikanNonFormalResource\Pages;

use App\Filament\Pegawai\Resources\PendidikanNonFormalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendidikanNonFormals extends ListRecords
{
    protected static string $resource = PendidikanNonFormalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
