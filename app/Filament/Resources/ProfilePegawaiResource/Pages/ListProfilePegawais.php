<?php

namespace App\Filament\Resources\ProfilePegawaiResource\Pages;

use App\Filament\Resources\ProfilePegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilePegawais extends ListRecords
{
    protected static string $resource = ProfilePegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
