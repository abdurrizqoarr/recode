<?php

namespace App\Filament\Resources\PegawaiAumResource\Pages;

use App\Filament\Resources\PegawaiAumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPegawaiAum extends EditRecord
{
    protected static string $resource = PegawaiAumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
