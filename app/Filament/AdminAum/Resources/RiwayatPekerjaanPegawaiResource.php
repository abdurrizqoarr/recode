<?php

namespace App\Filament\AdminAum\Resources;

use App\Filament\AdminAum\Resources\RiwayatPekerjaanPegawaiResource\Pages;
use App\Models\RiwayatPekerjaan;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.name')->label('Nama')->searchable(),
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
            ->query(function () {
                $idAum = Auth::guard('admin-aums')->user()->id_aum;
                return RiwayatPekerjaan::query()
                    ->whereHas('pegawai', function ($query) use ($idAum) {
                        $query->where('id_aum', $idAum);
                    });
            })
            ->filters([])
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
