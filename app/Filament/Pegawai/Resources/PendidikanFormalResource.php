<?php

namespace App\Filament\Pegawai\Resources;

use App\Filament\Pegawai\Resources\PendidikanFormalResource\Pages;
use App\Filament\Pegawai\Resources\PendidikanFormalResource\RelationManagers;
use App\Models\PendidikanFormal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendidikanFormalResource extends Resource
{
    protected static ?string $model = PendidikanFormal::class;

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
            'index' => Pages\ListPendidikanFormals::route('/'),
            'create' => Pages\CreatePendidikanFormal::route('/create'),
            'edit' => Pages\EditPendidikanFormal::route('/{record}/edit'),
        ];
    }
}
