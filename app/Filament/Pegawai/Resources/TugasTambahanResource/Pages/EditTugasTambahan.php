<?php

namespace App\Filament\Pegawai\Resources\TugasTambahanResource\Pages;

use App\Filament\Pegawai\Resources\TugasTambahanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTugasTambahan extends EditRecord
{
    protected static string $resource = TugasTambahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
