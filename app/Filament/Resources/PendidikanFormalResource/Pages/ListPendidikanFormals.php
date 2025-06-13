<?php

namespace App\Filament\Resources\PendidikanFormalResource\Pages;

use App\Filament\Resources\PendidikanFormalResource;
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
