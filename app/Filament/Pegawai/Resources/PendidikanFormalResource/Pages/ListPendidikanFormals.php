<?php

namespace App\Filament\Pegawai\Resources\PendidikanFormalResource\Pages;

use App\Filament\Pegawai\Resources\PendidikanFormalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendidikanFormals extends ListRecords
{
    protected static string $resource = PendidikanFormalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
