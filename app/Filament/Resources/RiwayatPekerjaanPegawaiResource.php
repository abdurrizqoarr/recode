<?php

namespace App\Filament\Resources;

use App\Filament\Exports\RiwayatPekerjaanExporter;
use App\Filament\Resources\RiwayatPekerjaanPegawaiResource\Pages;
use App\Models\RiwayatPekerjaan;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RiwayatPekerjaanPegawaiResource extends Resource
{
    protected static ?string $model = RiwayatPekerjaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Riwayat Pekerjaan Pegawai';
    protected static ?string $pluralModelLabel = 'Riwayat Pekerjaan Pegawai';

    public static function getLabel(): ?string
    {
        return 'Riwayat Pekerjaan Pegawai';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Riwayat Pekerjaan Pegawai';
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(RiwayatPekerjaanExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('pegawai.aum.namaAum')->label('Asal AUM')->sortable(),
                Tables\Columns\TextColumn::make('namaAum')->label('Nama AUM Sebelumnya')->searchable(),
                Tables\Columns\TextColumn::make('nomerAum')->label('Nomor AUM Sebelumnya')->searchable(),
                Tables\Columns\TextColumn::make('namaPenandatangan')->label('Nama Penandatangan Tugas')->searchable(),
                Tables\Columns\TextColumn::make('jabatanPenandaTangan')->label('Jabatan Penandatangan')->searchable(),
                Tables\Columns\TextColumn::make('nomerSK')->label('Nomor SK')->searchable(),
                Tables\Columns\TextColumn::make('masaKerjaDalamBulan')->label('Masa Kerja (Bulan)')->alignCenter(),
                Tables\Columns\TextColumn::make('tanggalSK')->label('Tanggal SK'),
                Tables\Columns\TextColumn::make('buktiSK')
                    ->alignCenter()
                    ->label('SK')
                    ->formatStateUsing(fn($state) => $state ? 'Download' : '-')
                    ->url(fn($record) => $record->buktiSK
                        ? route('download.document', ['filename' => $record->buktiSK])
                        : null)
                    ->openUrlInNewTab()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('aum')
                    ->label('AUM')
                    ->relationship('pegawai.aum', 'namaAum')
                    ->options(\App\Models\Aum::all()->pluck('namaAum', 'id'))
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
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
            'index' => Pages\ListRiwayatPekerjaanPegawais::route('/'),
        ];
    }
}
