<?php

namespace App\Filament\AdminAum\Resources\PegawaiAumResource\Pages;

use App\Filament\AdminAum\Resources\PegawaiAumResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePegawaiAum extends CreateRecord
{
    protected static string $resource = PegawaiAumResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil id_instansi dari user login dan tambahkan ke data
        $data['id_aum'] = Auth::guard('admin-aums')->user()->id_aum;
        return $data;
    }
}
