<?php

namespace App\Filament\Pegawai\Resources\RiwayatPekerjaanResource\Pages;

use App\Filament\Pegawai\Resources\RiwayatPekerjaanResource;
use App\Models\Profile;
use App\Models\RiwayatPekerjaan;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Auth;
use Throwable;
use function Filament\Support\is_app_url;

class RiwayatPekerjaanCreate extends CreateRecord
{
    protected static string $resource = RiwayatPekerjaanResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\TextInput::make('namaAum')
                    ->label('Nama AUM')
                    ->maxLength(240)
                    ->minLength(5)
                    ->required(),
                \Filament\Forms\Components\TextInput::make('nomerAum')
                    ->label('Nomor AUM')
                    ->maxLength(240)
                    ->minLength(5)
                    ->required(),
                \Filament\Forms\Components\TextInput::make('namaPenandatangan')
                    ->label('Nama Penandatangan SK')
                    ->maxLength(240)
                    ->minLength(5)
                    ->required(),
                \Filament\Forms\Components\TextInput::make('jabatanPenandaTangan')
                    ->label('Jabatan Penandatangan')
                    ->maxLength(240)
                    ->minLength(5)
                    ->required(),
                \Filament\Forms\Components\TextInput::make('nomerSK')
                    ->label('Nomor SK')
                    ->maxLength(240)
                    ->minLength(5)
                    ->columnSpanFull()
                    ->required(),
                \Filament\Forms\Components\DatePicker::make('tanggalMulaiSK')
                    ->label('Tanggal Mulai SK')
                    ->required()
                    ->maxDate(fn($get) => $get('tanggalSelesaiSK')),
                \Filament\Forms\Components\DatePicker::make('tanggalSelesaiSK')
                    ->label('Tanggal Selesai SK')
                    ->required()
                    ->minDate(fn($get) => $get('tanggalMulaiSK')),
                \Filament\Forms\Components\FileUpload::make('buktiSK')
                    ->label('Bukti SK')
                    ->required()
                    ->directory('sk-riwayat')
                    ->disk('local')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(4096),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tanggalMulai = $data['tanggalMulaiSK'] ?? null;
        $tanggalSelesai = $data['tanggalSelesaiSK'] ?? null;
        $data['id_pegawai'] = Auth::guard('pegawais')->id();

        // Hitung lama kerja dalam bulan jika kedua tanggal valid
        if ($tanggalMulai && $tanggalSelesai) {
            $mulai = Carbon::parse($tanggalMulai);
            $selesai = Carbon::parse($tanggalSelesai);

            // diffInMonths menghitung selisih bulan penuh. 
            // Tambah 1 jika Anda ingin bulan pertama dihitung sebagai 1 bulan kerja.
            $data['masaKerjaDalamBulan'] = $mulai->diffInMonths($selesai) + 1;
            $data['tanggalSK'] = $data['tanggalMulaiSK'];
        } else {
            // Set default value jika tanggal tidak lengkap
            $data['masaKerjaDalamBulan'] = 0;
            $data['tanggalSK'] = $data['tanggalMulaiSK'];
        }

        // Kembalikan array data yang sudah dimodifikasi
        return $data;
    }

    protected function handleRecordCreation(array $data): RiwayatPekerjaan
    {
        // Buat record RiwayatPekerjaan
        $record = RiwayatPekerjaan::create($data);

        // Tambahkan logika update Profile di sini
        if ($record->masaKerjaDalamBulan > 0) {
            $profile = Profile::where('id_pegawai', $record->id_pegawai)->first();

            if ($profile) {
                $profile->increment('totalMasaKerja', $record->masaKerjaDalamBulan);
            }
        }

        return $record;
    }
}
