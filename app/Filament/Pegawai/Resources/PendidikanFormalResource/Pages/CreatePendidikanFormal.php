<?php

namespace App\Filament\Pegawai\Resources\PendidikanFormalResource\Pages;

use App\Filament\Pegawai\Resources\PendidikanFormalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePendidikanFormal extends CreateRecord
{
    protected static string $resource = PendidikanFormalResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_pegawai'] = Auth::guard('pegawais')->id();
        return $data;
    }
}
