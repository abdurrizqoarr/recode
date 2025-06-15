<?php

namespace App\Filament\Pegawai\Resources\TugasMapelResource\Pages;

use App\Filament\Pegawai\Resources\TugasMapelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTugasMapel extends EditRecord
{
    protected static string $resource = TugasMapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
