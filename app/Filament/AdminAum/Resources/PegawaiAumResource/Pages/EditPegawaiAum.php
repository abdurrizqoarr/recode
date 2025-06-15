<?php

namespace App\Filament\AdminAum\Resources\PegawaiAumResource\Pages;

use App\Filament\AdminAum\Resources\PegawaiAumResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditPegawaiAum extends EditRecord
{
    protected static string $resource = PegawaiAumResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $aum = \App\Models\Aum::find($data['id_aum']);

        // Jika AUM tidak ditemukan atau statusnya tidak aktif, hentikan proses
        if (!$aum || $aum->izinTambahPegawai == 0) {
            Notification::make()
                ->title('Gagal Menyimpan')
                ->body('AUM yang dipilih dibatasi.')
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'id_aum' => 'AUM yang dipilih tidak aktif atau tidak diizinkan menambah pegawai.',
            ]);
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
