<?php

namespace App\Filament\Pegawai\Resources;

use App\Filament\Pegawai\Resources\PendidikanNonFormalResource\Pages;
use App\Filament\Pegawai\Resources\PendidikanNonFormalResource\RelationManagers;
use App\Models\PendidikanNonFormal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendidikanNonFormalResource extends Resource
{
    protected static ?string $model = PendidikanNonFormal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPendidikanNonFormals::route('/'),
            'create' => Pages\CreatePendidikanNonFormal::route('/create'),
            'edit' => Pages\EditPendidikanNonFormal::route('/{record}/edit'),
        ];
    }
}
