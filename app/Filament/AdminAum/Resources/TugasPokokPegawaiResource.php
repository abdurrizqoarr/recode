<?php

namespace App\Filament\AdminAum\Resources;

use App\Filament\AdminAum\Resources\TugasPokokPegawaiResource\Pages;
use App\Models\Aum;
use App\Models\PegawaiAum;
use App\Models\TugasPokok;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TugasPokokPegawaiResource extends Resource
{
    protected static ?string $model = TugasPokok::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Tugas Pokok Pegawai';
    protected static ?string $pluralModelLabel = 'Tugas Pokok Pegawai';

    public static function getLabel(): ?string
    {
        return 'Tugas Pokok Pegawai';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Tugas Pokok Pegawai';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_pegawai')
                    ->required()
                    ->label('Pegawai')
                    ->columnSpanFull()
                    ->options(function () {
                        return PegawaiAum::where('id_aum', Auth::guard('admin-aums')->user()->id_aum)
                            ->pluck('name', 'id');
                    })
                    ->searchable()
                    ->reactive()
                    ->disabled(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord)
                    ->dehydrated(true)
                    ->unique(ignorable: fn($record) => $record)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $pegawai = PegawaiAum::find($state);
                        $aum = Aum::find($pegawai?->id_aum);
                        $set('namaAum', $aum?->namaAum);
                        $set('nomerAum', $aum?->npsm);
                    }),

                TextInput::make('namaAum')
                    ->required()
                    ->label('Nama AUM Tempat Tugas Pokok')
                    ->minLength(2)
                    ->disabled() // Tidak bisa diubah user
                    ->dehydrated(true), // Tetap dikirim saat submit

                TextInput::make('nomerAum')
                    ->required()
                    ->label('Nomer Aum Tempat Tugas Pokok')
                    ->minLength(2)
                    ->disabled()
                    ->dehydrated(true),
                TextInput::make('tugasPokok')
                    ->columnSpanFull()
                    ->maxLength(240)
                    ->minLength(2)
                    ->required()
                    ->label("Tugas Pokok Pegawai")
                    ->columnSpanFull(),
                TextInput::make('namaPenandatangan')
                    ->required()
                    ->maxLength(240)
                    ->minLength(2)
                    ->label("Nama Penanda Tangan SK"),
                TextInput::make('jabatanPenandaTangan')
                    ->maxLength(240)
                    ->minLength(2)
                    ->required()
                    ->label("Jabatan Penanda Tangan SK"),
                TextInput::make('nomerSK')
                    ->maxLength(240)
                    ->minLength(2)
                    ->required()
                    ->label("Nomer SK Tugas Pokok"),
                DatePicker::make('tanggalSK')
                    ->required()
                    ->label("Tangal SK Tugas Pokok"),
                Forms\Components\FileUpload::make('buktiSK')
                    ->label('Dokumen SK')
                    ->disk('local')
                    ->directory('sk-tugas-pokok')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(4096) // dalam kilobyte, 4096 KB = 4 MB
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('pegawai.aum.namaAum')->label('Asal AUM')->sortable(),
                Tables\Columns\TextColumn::make('tugasPokok')->label('Tugas Pokok')->searchable(),
                Tables\Columns\TextColumn::make('namaPenandatangan')->label('Nama Penandatangan')->searchable(),
                Tables\Columns\TextColumn::make('jabatanPenandaTangan')->label('Jabatan Penandatangan')->searchable(),
                Tables\Columns\TextColumn::make('nomerSK')->label('Nomor SK')->searchable(),
                Tables\Columns\TextColumn::make('tanggalSK')->label('Tanggal SK')->date(),
                Tables\Columns\TextColumn::make('buktiSK')
                    ->alignCenter()
                    ->label('Dokumen SK')
                    ->formatStateUsing(fn($state) => $state ? 'Download' : '-')
                    ->url(fn($record) => $record->buktiSK
                        ? route('download.document', ['filename' => $record->buktiSK])
                        : null)
                    ->openUrlInNewTab()
                    ->toggleable(),
            ])
            ->query(function () {
                $idAum = Auth::guard('admin-aums')->user()->id_aum;
                return TugasPokok::query()
                    ->whereHas('pegawai', function ($query) use ($idAum) {
                        $query->where('id_aum', $idAum);
                    });
            })
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('selesaikan')
                        ->label('Selesaikan')
                        ->color('success')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->modalDescription('Apakah anda yakin ingin menyelesaikan tugas pokok pegawai ini?.')
                        ->modalSubmitActionLabel('Yes, Selesaikan')
                        ->modalHeading('Konfirmasi Selesaikan Tugas Pokok')
                        ->action(function ($record) {
                            // Hitung tanggal selesai dan lama bekerja dalam bulan
                            $tanggalMulai = $record->tanggalSK;
                            $tanggalSelesai = now();
                            $lamaBekerja = \Carbon\Carbon::parse($tanggalMulai)->diffInMonths($tanggalSelesai);

                            // Pindahkan ke RiwayatPekerjaan
                            \App\Models\RiwayatPekerjaan::create([
                                'id_pegawai' => $record->id_pegawai,
                                'namaAum' => $record->namaAum,
                                'nomerAum' => $record->nomerAum,
                                'namaPenandatangan' => $record->namaPenandatangan,
                                'jabatanPenandaTangan' => $record->jabatanPenandaTangan,
                                'nomerSK' => $record->nomerSK,
                                'masaKerjaDalamBulan' => $lamaBekerja,
                                'tanggalSK' => $record->tanggalSK,
                                'buktiSK' => $record->buktiSK,
                            ]);

                            // Hapus dari TugasPokok
                            $record->delete();
                        })
                        ->visible(fn($record) => true),
                ])
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTugasPokokPegawais::route('/'),
            'create' => Pages\CreateTugasPokokPegawai::route('/create'),
            'edit' => Pages\EditTugasPokokPegawai::route('/{record}/edit'),
        ];
    }
}
