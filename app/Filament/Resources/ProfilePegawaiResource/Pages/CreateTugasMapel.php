<?php

namespace App\Filament\Resources\ProfilePegawaiResource\Pages;

use App\Filament\Resources\ProfilePegawaiResource;
use App\Models\Profile;
use App\Models\TugasMapel;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CreateTugasMapel extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static string $resource = ProfilePegawaiResource::class;

    protected static string $view = 'filament.resources.profile-pegawai-resource.pages.create-tugas-mapel';

    public $profile = null;
    public ?array $data = [];

    public function mount($record): void
    {
        $this->profile = Profile::with('pegawaiAum')->findOrFail($record);

        // Mengisi 'state' form dengan data dari profile dan nilai default
        $this->form->fill([
            'name' => $this->profile->pegawaiAum->name,
            'id_pegawai' => $this->profile->id_pegawai,
            'mapelDiampu' => '',
            'totalJamSeminggu' => '',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            // Hubungkan form ini dengan properti $data
            ->statePath('data')
            ->schema([
                Section::make('Profile')
                    ->description('Data pegawai yang akan diberi tugas tambahan.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama')
                                ->required()
                                ->disabled(),
                            TextInput::make('id_pegawai')
                                ->label('ID Pegawai')
                                ->required()
                                ->disabled(),
                        ]),
                    ]),
                Section::make('Input Tugas Tambahan')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('mapelDiampu')
                                ->label('Mapel Yang Diampu')
                                ->minLength(2)
                                ->maxLength(240)
                                ->required(),
                            TextInput::make('totalJamSeminggu')
                                ->label('Total Jam Dalam Seminggu')
                                ->numeric()
                                ->minValue(0)
                                ->integer()
                                ->required(),
                        ])
                    ]),
            ]);
    }

    public function create(): void
    {
        $formData = $this->form->getState();
        try {
            // Ambil semua data yang sudah tervalidasi dari form

            // Simpan data ke database
            TugasMapel::create([
                'id_pegawai' => $this->profile->id_pegawai,
                'mapelDiampu' => $formData['mapelDiampu'],
                'totalJamSeminggu' => $formData['totalJamSeminggu'],
                // Sesuaikan nama kolom lain jika ada
            ]);

            // Kirim notifikasi sukses
            Notification::make()
                ->title('Tugas mapel berhasil disimpan')
                ->success()
                ->send();

            // Kosongkan kembali field input setelah berhasil disimpan
            $this->form->fill([
                'name' => $this->profile->pegawaiAum->name,
                'id_pegawai' => $this->profile->id_pegawai,
                'mapelDiampu' => '',
                'totalJamSeminggu' => '',
            ]);
        } catch (\Throwable $e) {
            // Kirim notifikasi error
            Notification::make()
                ->title('Gagal menyimpan tugas mapel')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
        // Table akan otomatis refresh karena state berubah
    }

    public function table(Table $table): Table
    {
        return $table
            // 4. Perbaiki query dengan menggunakan Closure agar $this->profile tidak null
            ->query(fn(): Builder => TugasMapel::query()->where('id_pegawai', $this->profile->id_pegawai)->orderBy('created_at', 'DESC'))
            ->columns([
                TextColumn::make('mapelDiampu')
                    ->wrap() // Agar teks panjang bisa turun baris
                    ->searchable(),
                TextColumn::make('totalJamSeminggu')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->emptyStateHeading('Belum ada tugas mapel untuk pegawai ini.');
    }
}
