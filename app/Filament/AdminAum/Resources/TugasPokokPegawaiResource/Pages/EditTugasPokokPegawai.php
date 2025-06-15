<?php

namespace App\Filament\AdminAum\Resources\TugasPokokPegawaiResource\Pages;

use App\Filament\AdminAum\Resources\TugasPokokPegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTugasPokokPegawai extends EditRecord
{
    protected static string $resource = TugasPokokPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
