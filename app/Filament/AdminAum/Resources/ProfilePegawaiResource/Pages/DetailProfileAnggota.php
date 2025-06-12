<?php

namespace App\Filament\AdminAum\Resources\ProfilePegawaiResource\Pages;

use App\Filament\AdminAum\Resources\ProfilePegawaiResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class DetailProfileAnggota extends ViewRecord
{
    protected static string $resource = ProfilePegawaiResource::class;

    public function getTitle(): string
    {
        return 'Detail Profile Pegawai';
    }

    public function mount(int|string $record): void
    {
        // Ambil record Profile beserta relasi anggota dan ranting-nya
        $this->record = \App\Models\Profile::with(['pegawaiAum'])->findOrFail($record);

        $this->authorizeAccess();

        // Biarkan method fillForm() yang akan isi form
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $record = $this->getRecord();

        $this->form->fill([
            'name' => $record->pegawaiAum->name,
            'noKTAM' => $record->noKTAM,
            'noKTP' => $record->noKTP,
            'noNIPY' => $record->noNIPY,
            'tempatLahir' => $record->tempatLahir,
            'jenisKelamin' => $record->jenisKelamin,
            'tanggalLahir' => $record->tanggalLahir,
            'isMarried' => $record->isMarried,
            'alamat' => $record->alamat,
            'fotoProfile' => $record->fotoProfile,
            'noTelp' => $record->noTelp,
            'totalMasaKerja' => $record->totalMasaKerja,
        ]);
    }
}
