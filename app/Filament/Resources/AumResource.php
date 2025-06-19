<?php

namespace App\Filament\Resources;

use App\Filament\Exports\AumExporter;
use App\Filament\Resources\AumResource\Pages;
use App\Models\Aum;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;

class AumResource extends Resource
{
    protected static ?string $model = AUM::class;

    protected static ?string $navigationIcon = 'fas-school-flag';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Dashboard';

    protected static ?string $navigationLabel = 'AUM';

    protected static ?string $modelLabel = 'AUM';
    protected static ?string $pluralModelLabel = 'AUM';

    public static function getLabel(): ?string
    {
        return 'AUM';
    }

    public static function getPluralLabel(): ?string
    {
        return 'AUM';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('namaAum')
                    ->label('Nama AUM')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('npsm')
                    ->label('NPSN')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamatAum')
                    ->label('Alamat AUM')
                    ->maxLength(255),
                Forms\Components\TextInput::make('teleponAum')
                    ->label('Telepon AUM')
                    ->maxLength(255),
                Forms\Components\TextInput::make('emailAum')
                    ->label('Email AUM')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('websiteAum')
                    ->label('Website AUM')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('logoAum')
                    ->label('Logo AUM')
                    ->image()
                    ->directory('logos')
                    ->disk('public')
                    ->maxSize(3072)
                    ->previewable(),
                Toggle::make('izinTambahPegawai')
                    ->label('Izin Tambah Pegawai')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(AumExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('namaAum')
                    ->label('Nama AUM')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npsm')
                    ->label('NPSN')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamatAum')
                    ->label('Alamat AUM')
                    ->limit(30),
                Tables\Columns\TextColumn::make('teleponAum')
                    ->label('Telepon AUM')
                    ->limit(20),
                Tables\Columns\TextColumn::make('emailAum')
                    ->label('Email AUM')
                    ->limit(30),
                Tables\Columns\TextColumn::make('websiteAum')
                    ->label('Website AUM')
                    ->limit(30),
                Tables\Columns\ImageColumn::make('logoAum')
                    ->label('Logo AUM')
                    ->size(60)
                    ->circular()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('izinTambahPegawai')
                    ->label('Izin Tambah Pegawai')
                    ->alignCenter()
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ], position: ActionsPosition::BeforeColumns)
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
            'index' => Pages\ListAums::route('/'),
            'create' => Pages\CreateAum::route('/create'),
            'edit' => Pages\EditAum::route('/{record}/edit'),
        ];
    }
}
