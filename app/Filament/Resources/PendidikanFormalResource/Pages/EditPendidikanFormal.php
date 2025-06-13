<?php

namespace App\Filament\Resources\PendidikanFormalResource\Pages;

use App\Filament\Resources\PendidikanFormalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendidikanFormal extends EditRecord
{
    protected static string $resource = PendidikanFormalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
