<?php

namespace App\Filament\Resources\PendidikanNonFormalResource\Pages;

use App\Filament\Resources\PendidikanNonFormalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendidikanNonFormal extends EditRecord
{
    protected static string $resource = PendidikanNonFormalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
