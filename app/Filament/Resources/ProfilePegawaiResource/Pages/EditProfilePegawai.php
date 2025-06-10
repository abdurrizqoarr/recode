<?php

namespace App\Filament\Resources\ProfilePegawaiResource\Pages;

use App\Filament\Resources\ProfilePegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfilePegawai extends EditRecord
{
    protected static string $resource = ProfilePegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
