<?php

namespace App\Filament\Pegawai\Pages;

use App\Models\Profile as ModelsProfile;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

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
                        \Filament\Forms\Components\Toggle::make('isMarried')
                            ->label('Sudah Menikah'),
                        \Filament\Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\FileUpload::make('fotoProfile')
                            ->label('Foto Profil')
                            ->image()
                            ->directory('profile-photos')
                            ->nullable(),
                        \Filament\Forms\Components\TextInput::make('noTelp')
                            ->label('No. Telepon')
                            ->tel()
                            ->nullable(),
                        \Filament\Forms\Components\TextInput::make('totalMasaKerja')
                            ->label('Total Masa Kerja')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])
                ])
        ])->statePath('data');
    }

    public function submit()
    {
        try {
            dd($this->form->getState());
            $user = Auth::guard('pegawais')->user();

            ModelsProfile::updateOrCreate(
                ['id_pegawai' => $user->id],
                array_merge(
                    $this->form->getState(),
                    ['id_pegawai' => $user->id]
                )
            );

            Notification::make()
                ->title('Perbarui Profile Berhasil')
                ->duration(3000)
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Terjadi kesalahan saat menyimpan data')
                ->body($e->getMessage())
                ->danger()
                ->duration(5000)
                ->send();
        }
    }
}
