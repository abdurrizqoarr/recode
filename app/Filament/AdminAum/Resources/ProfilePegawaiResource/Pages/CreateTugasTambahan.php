<?php

namespace App\Filament\AdminAum\Resources\ProfilePegawaiResource\Pages;

use App\Filament\AdminAum\Resources\ProfilePegawaiResource;
use App\Models\Profile;
use App\Models\TugasTambahan;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CreateTugasTambahan extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static string $resource = ProfilePegawaiResource::class;

    protected static string $view = 'filament.admin-aum.resources.profile-pegawai-resource.pages.create-tugas-tambahan';

    public $profile = null;
    public ?array $data = [];

    public function mount($record): void
    {
        $this->profile = Profile::with('pegawaiAum')->findOrFail($record);

        // Mengisi 'state' form dengan data dari profile dan nilai default
        $this->form->fill([
            'name' => $this->profile->pegawaiAum->name,
            'id_pegawai' => $this->profile->id_pegawai,
            'tugasTambahan' => '', // Nilai awal untuk input tugas
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
                        TextInput::make('tugasTambahan')
                            ->label('Tugas Tambahan')
                            ->minLength(2)
                            ->maxLength(240)
                            ->required() // Tambahkan validasi jika perlu
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function create(): void
    {
        $formData = $this->form->getState();
        try {
            TugasTambahan::create([
                'id_pegawai' => $this->profile->id_pegawai,
                'tugasTambahan' => $formData['tugasTambahan'],
                // Sesuaikan nama kolom lain jika ada
            ]);

            // Kirim notifikasi sukses
            Notification::make()
                ->title('Tugas tambahan berhasil disimpan')
                ->success()
                ->send();

            // Kosongkan kembali field input setelah berhasil disimpan
            $this->form->fill([
                'name' => $this->profile->pegawaiAum->name,
                'id_pegawai' => $this->profile->id_pegawai,
                'tugasTambahan' => '',
            ]);
        } catch (\Throwable $e) {
            // Kirim notifikasi error
            Notification::make()
                ->title('Gagal menyimpan tugas tambahan')
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
            ->query(fn(): Builder => TugasTambahan::query()->where('id_pegawai', $this->profile->id_pegawai)->orderBy('created_at', 'DESC'))
            ->columns([
                TextColumn::make('tugasTambahan')
                    ->wrap() // Agar teks panjang bisa turun baris
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->emptyStateHeading('Belum ada tugas tambahan untuk pegawai ini.');
    }
}
