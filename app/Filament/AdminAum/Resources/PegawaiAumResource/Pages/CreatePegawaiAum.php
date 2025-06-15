<?php

namespace App\Filament\AdminAum\Resources\PegawaiAumResource\Pages;

use App\Filament\AdminAum\Resources\PegawaiAumResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CreatePegawaiAum extends CreateRecord
{
    protected static string $resource = PegawaiAumResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil id_aum dari user yang sedang login
        $data['id_aum'] = Auth::guard('admin-aums')->user()->id_aum;

        // Ambil data AUM berdasarkan id_aum
        $aum = \App\Models\Aum::find($data['id_aum']);

        // Jika AUM tidak ditemukan atau tidak diizinkan menambah pegawai
        if (!$aum || $aum->izinTambahPegawai == 0) {
            Notification::make()
                ->title('Gagal Menyimpan')
                ->body('AUM yang dipilih dibatasi oleh ADMIN MASTER.')
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'id_aum' => 'AUM yang dipilih tidak aktif atau tidak diizinkan menambah pegawai.',
            ]);
        }

        return $data;
    }
}
