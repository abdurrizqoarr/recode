<?php

namespace App\Filament\Pegawai\Resources;

use App\Filament\Pegawai\Resources\TugasTambahanResource\Pages;
use App\Models\TugasTambahan;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TugasTambahanResource extends Resource
{
    protected static ?string $model = TugasTambahan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Penugasan';

    protected static ?string $modelLabel = 'Tugas Tambahan';
    protected static ?string $pluralModelLabel = 'Tugas Tambahan';

    public static function getLabel(): ?string
    {
        return 'Tugas Tambahan';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Tugas Tambahan';
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tugasTambahan')
                    ->label('Tugas Tambahan')
                    ->searchable(),
            ])
            ->query(function () {
                $idUser = Auth::guard('pegawais')->id();
                return TugasTambahan::query()->where('id_pegawai', $idUser);
            })
            ->filters([])
            ->actions([])
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
            'index' => Pages\ListTugasTambahans::route('/'),
        ];
    }
}
