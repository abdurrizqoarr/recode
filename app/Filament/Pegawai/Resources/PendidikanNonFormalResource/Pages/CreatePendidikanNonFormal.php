<?php

namespace App\Filament\Pegawai\Resources\PendidikanNonFormalResource\Pages;

use App\Filament\Pegawai\Resources\PendidikanNonFormalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePendidikanNonFormal extends CreateRecord
{
    protected static string $resource = PendidikanNonFormalResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_pegawai'] = Auth::guard('pegawais')->id();
        return $data;
    }
}
