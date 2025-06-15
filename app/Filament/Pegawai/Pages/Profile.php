<?php

namespace App\Filament\Pegawai\Pages;

use App\Models\Profile as ModelsProfile;
use App\Models\RiwayatPekerjaan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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

    public ?ModelsProfile $record = null;

    public function mount(): void
    {
        $user = Auth::guard('pegawais')->user();

        // Find the existing profile for the user, or create a new, unsaved instance.
        // This ensures `$this->record` is always a valid model instance.
        $this->record = ModelsProfile::firstOrNew(['id_pegawai' => $user->id]);

        // Fill the form with the record's data.
        $this->form->fill($this->record->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profil')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('noKTAM')
                                ->label('No. KTAM')
                                ->maxLength(50),
                            TextInput::make('noKTP')
                                ->label('No. KTP')
                                ->maxLength(16),
                            TextInput::make('noNIPY')
                                ->label('No. NIPY')
                                ->maxLength(50),
                            TextInput::make('tempatLahir')
                                ->label('Tempat Lahir')
                                ->required()
                                ->maxLength(100),
                            Radio::make('isMarried')
                                ->label('Sudah Menikah')
                                ->options([
                                    true => 'Ya',
                                    false => 'Tidak',
                                ])
                                ->boolean()
                                ->default(false)
                                ->required(),
                            Select::make('jenisKelamin')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'Laki - Laki' => 'Laki - Laki',
                                    'Perempuan' => 'Perempuan',
                                ])
                                ->required(),
                            DatePicker::make('tanggalLahir')
                                ->label('Tanggal Lahir')
                                ->required()
                                ->before('today'),
                            Textarea::make('alamat')
                                ->label('Alamat')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            FileUpload::make('fotoProfile')
                                ->label('Foto Profil')
                                ->image()
                                ->disk('public')
                                ->directory('profile-photos')
                                ->maxSize(3072) // maksimal 3MB (dalam kilobyte)
                                ->nullable()
                                ->imagePreviewHeight('150')
                                ->imageCropAspectRatio('1:1')
                                ->imageResizeTargetWidth('300')
                                ->imageResizeTargetHeight('300'),
                            TextInput::make('noTelp')
                                ->label('No. Telepon')
                                ->tel()
                                ->numeric()
                                ->minLength(10)
                                ->maxLength(15)
                                ->nullable(),
                        ]),
                    ]),
            ])
            ->statePath('data')
            // KEY CHANGE: Bind the form to the Eloquent model instance.
            // This allows `ignoreRecord: true` to know which record to exclude.
            ->model($this->record);
    }

    public function submit()
    {
        $data = $this->form->getState();
        try {
            $user = Auth::guard('pegawais')->user();

            $totalMasaKerja = RiwayatPekerjaan::where('id_pegawai', $user->id)
                ->sum('masaKerjaDalamBulan');

            ModelsProfile::updateOrCreate(
                ['id_pegawai' => $user->id],
                [
                    ...$data,
                    'totalMasaKerja' => $totalMasaKerja,
                ]
            );

            Notification::make()
                ->title('Perbarui Profile Berhasil')
                ->duration(3000)
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui profil pegawai: ' . $e->getMessage(), ['user_id' => $user->id ?? null]);

            Notification::make()
                ->title('Terjadi Kesalahan')
                ->body('Tidak dapat menyimpan perubahan. Silakan coba beberapa saat lagi.')
                ->danger()
                ->send();
        }
    }
}
