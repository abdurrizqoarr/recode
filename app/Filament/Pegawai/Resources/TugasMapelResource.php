<?php

namespace App\Filament\Pegawai\Resources;

use App\Filament\Pegawai\Resources\TugasMapelResource\Pages;
use App\Filament\Pegawai\Resources\TugasMapelResource\RelationManagers;
use App\Models\TugasMapel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TugasMapelResource extends Resource
{
    protected static ?string $model = TugasMapel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Tugas Mapel';
    protected static ?string $pluralModelLabel = 'Tugas Mapel';

    public static function getLabel(): ?string
    {
        return 'Tugas Mapel';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Tugas Mapel';
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
                Tables\Columns\TextColumn::make('mapelDiampu')
                    ->label('Mata Pelajaran Diampu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('totalJamSeminggu')
                    ->label('Total Jam / Minggu')
                    ->sortable(),
            ])
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
            'index' => Pages\ListTugasMapels::route('/'),
        ];
    }
}
