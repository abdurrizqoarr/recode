<?php

namespace App\Filament\AdminAum\Resources;

use App\Filament\AdminAum\Resources\PegawaiAumResource\Pages;
use App\Models\PegawaiAum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PegawaiAumResource extends Resource
{
    protected static ?string $model = PegawaiAum::class;

    protected static ?string $navigationIcon = 'fas-user-plus';
    protected static ?string $navigationLabel = 'Pegawai AUM';

    protected static ?int $navigationSort = 3;
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
                    ->minLength(2)
                    ->maxLength(240)
                    ->unique(ignoreRecord: true),
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->minLength(2)
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
                    ->dehydrateStateUsing(fn($state) => bcrypt($state)),
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
            ])
            ->query(function () {
                $idAum = Auth::guard('admin-aums')->user()->id_aum;
                return PegawaiAum::query()->where('id_aum', $idAum);
            })
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
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
