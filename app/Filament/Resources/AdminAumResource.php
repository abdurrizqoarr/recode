<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminAumResource\Pages;
use App\Filament\Resources\AdminAumResource\RelationManagers;
use App\Models\AdminAum;
use App\Models\Aum;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminAumResource extends Resource
{
    protected static ?string $model = AdminAum::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Admin AUM';

    protected static ?string $modelLabel = 'Admin AUM';
    protected static ?string $pluralModelLabel = 'Admin AUM';

    public static function getLabel(): ?string
    {
        return 'Admin AUM';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Admin AUM';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(240)
                    ->unique(ignoreRecord: true),
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(240)
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->minLength(6)
                    ->maxLength(240)
                    ->dehydrateStateUsing(fn($state) => bcrypt($state)),
                Select::make('id_aum')
                    ->required()
                    ->label('AUM')
                    ->options(Aum::all()->pluck('namaAum', 'id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('aum.namaAum')
                    ->label('AUM')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('id_aum')
                    ->label('Aum')
                    ->options(\App\Models\Aum::all()->pluck('namaAum', 'id'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAdminAums::route('/'),
            'create' => Pages\CreateAdminAum::route('/create'),
            'edit' => Pages\EditAdminAum::route('/{record}/edit'),
        ];
    }
}
