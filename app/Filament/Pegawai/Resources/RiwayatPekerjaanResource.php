<?php

namespace App\Filament\Pegawai\Resources;

use App\Filament\Pegawai\Resources\RiwayatPekerjaanResource\Pages;
use App\Filament\Pegawai\Resources\RiwayatPekerjaanResource\RelationManagers;
use App\Models\RiwayatPekerjaan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RiwayatPekerjaanResource extends Resource
{
    protected static ?string $model = RiwayatPekerjaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Riwayat Pekerjaan';
    protected static ?string $pluralModelLabel = 'Riwayat Pekerjaan';

    public static function getLabel(): ?string
    {
        return 'Riwayat Pekerjaan';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Riwayat Pekerjaan';
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('namaAum')->label('Nama AUM')->searchable(),
                Tables\Columns\TextColumn::make('nomerAum')->label('Nomor AUM')->searchable(),
                Tables\Columns\TextColumn::make('namaPenandatangan')->label('Nama Penandatangan')->searchable(),
                Tables\Columns\TextColumn::make('jabatanPenandaTangan')->label('Jabatan Penandatangan')->searchable(),
                Tables\Columns\TextColumn::make('nomerSK')->label('Nomor SK')->searchable(),
                Tables\Columns\TextColumn::make('masaKerjaDalamBulan')->label('Masa Kerja (Bulan)'),
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
                $idUser = Auth::guard('pegawais')->id();
                return RiwayatPekerjaan::query()->where('id_pegawai', $idUser);
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
            'index' => Pages\ListRiwayatPekerjaans::route('/'),
            'create' => Pages\RiwayatPekerjaanCreate::route('/create'),
        ];
    }
}
