<?php

namespace App\Filament\Resources\AumResource\Pages;

use App\Filament\Resources\AumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAum extends EditRecord
{
    protected static string $resource = AumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
