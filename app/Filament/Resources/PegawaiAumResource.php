<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiAumResource\Pages;
use App\Models\Aum;
use App\Models\PegawaiAum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PegawaiAumResource extends Resource
{
    protected static ?string $model = PegawaiAum::class;

    protected static ?string $navigationIcon = 'fas-user-plus';
    protected static ?string $navigationLabel = 'Pegawai AUM';

    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Dashboard';

    protected static ?string $modelLabel = 'Pegawai AUM';
    protected static ?string $pluralModelLabel = 'Pegawai AUM';

    public static function getLabel(): ?string
    {
        return 'Pegawai AUM';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Pegawai AUM';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(240),
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(240)
                    ->unique(ignoreRecord: true),
                Select::make('status')
                    ->label('Status')
                    ->required()
                    ->options([
                        'Pegawai Tetap Yayasan' => 'Pegawai Tetap Yayasan',
                        'Guru Tetap Yayasan' => 'Guru Tetap Yayasan',
                        'Pegawai Kontrak Yayasan' => 'Pegawai Kontrak Yayasan',
                        'Guru Kontrak Yayasan' => 'Guru Kontrak Yayasan',
                        'Guru Honor Sekolah' => 'Guru Honor Sekolah',
                        'Tenaga Honor Sekolah' => 'Tenaga Honor Sekolah',
                        'Guru Tamu' => 'Guru Tamu',
                    ]),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->minLength(6)
                    ->maxLength(240)
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->required(fn(Get $get, ?string $context) => $context === 'create')
                    ->dehydrated(fn($state) => filled($state)),
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('status'),
                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aum.namaAum')
                    ->label('AUM')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('id_aum')
                    ->label('AUM')
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
            'index' => Pages\ListPegawaiAums::route('/'),
            'create' => Pages\CreatePegawaiAum::route('/create'),
            'edit' => Pages\EditPegawaiAum::route('/{record}/edit'),
        ];
    }
}
