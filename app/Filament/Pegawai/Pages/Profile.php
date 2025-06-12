<?php

namespace App\Filament\Pegawai\Pages;

use App\Models\Profile as ModelsProfile;
use App\Models\RiwayatPekerjaan;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.pegawai.pages.profile';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::guard('pegawais')->user();

        $profile = ModelsProfile::where('id_pegawai', $user->id)->first();

        if ($profile) {
            $this->form->fill($profile->toArray());
        }
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\Section::make('Profil')
                ->schema([
                    Grid::make(2)->schema([
                        \Filament\Forms\Components\TextInput::make('noKTAM')
                            ->label('No. KTAM')
                            ->required()
                            ->unique(ignoreRecord: true),
                        \Filament\Forms\Components\TextInput::make('noKTP')
                            ->label('No. KTP')
                            ->required()
                            ->unique(ignoreRecord: true),
                        \Filament\Forms\Components\TextInput::make('noNIPY')
                            ->label('No. NIPY')
                            ->required()
                            ->unique(ignoreRecord: true),
                        \Filament\Forms\Components\TextInput::make('tempatLahir')
                            ->label('Tempat Lahir')
                            ->required(),
                        \Filament\Forms\Components\Radio::make('isMarried')
                            ->label('Sudah Menikah')
                            ->options([
                                true => 'Ya',
                                false => 'Tidak',
                            ])
                            ->boolean()
                            ->default(false),
                        \Filament\Forms\Components\Select::make('jenisKelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki - Laki' => 'Laki - Laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required(),
                        \Filament\Forms\Components\DatePicker::make('tanggalLahir')
                            ->label('Tanggal Lahir')
                            ->required(),
                        \Filament\Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\FileUpload::make('fotoProfile')
                            ->label('Foto Profil')
                            ->image()
                            ->disk('public')
                            ->previewable()
                            ->directory('profile-photos')
                            ->maxSize(3072) // maksimal 3MB (dalam kilobyte)
                            ->nullable(),
                        \Filament\Forms\Components\TextInput::make('noTelp')
                            ->label('No. Telepon')
                            ->tel()
                            ->nullable(),
                    ])
                ])
        ])->statePath('data');
    }

    public function submit()
    {
        try {
            $user = Auth::guard('pegawais')->user();

            $totalMasaKerja = RiwayatPekerjaan::where('id_pegawai', $user->id)
                ->sum('masaKerjaDalamBulan');

            ModelsProfile::updateOrCreate(
                ['id_pegawai' => $user->id], // Kunci untuk mencari
                [
                    ...$this->form->getState(), // Data dari form
                    'totalMasaKerja' => $totalMasaKerja, // Data hasil kalkulasi
                ]
            );

            Notification::make()
                ->title('Perbarui Profile Berhasil')
                ->duration(3000)
                ->success()
                ->send();
        } catch (\Throwable $e) {
            // 4. Tangani error dengan aman
            Log::error('Gagal memperbarui profil pegawai: ' . $e->getMessage(), ['user_id' => $user->id ?? null]);

            Notification::make()
                ->title('Terjadi Kesalahan')
                ->body('Tidak dapat menyimpan perubahan. Silakan coba beberapa saat lagi.')
                ->danger()
                ->send();
        }
    }
}
