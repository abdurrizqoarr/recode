<?php

namespace App\Filament\Pegawai\Resources\TugasMapelResource\Pages;

use App\Filament\Pegawai\Resources\TugasMapelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTugasMapels extends ListRecords
{
    protected static string $resource = TugasMapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
