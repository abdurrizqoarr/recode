<?php

namespace App\Filament\AdminAum\Resources\PendidikanFormalPegawaiResource\Pages;

use App\Filament\AdminAum\Resources\PendidikanFormalPegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendidikanFormalPegawai extends EditRecord
{
    protected static string $resource = PendidikanFormalPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
