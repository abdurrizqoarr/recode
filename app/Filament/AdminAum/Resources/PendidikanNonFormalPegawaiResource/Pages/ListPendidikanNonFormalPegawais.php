<?php

namespace App\Filament\AdminAum\Resources\PendidikanNonFormalPegawaiResource\Pages;

use App\Filament\AdminAum\Resources\PendidikanNonFormalPegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendidikanNonFormalPegawais extends ListRecords
{
    protected static string $resource = PendidikanNonFormalPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
