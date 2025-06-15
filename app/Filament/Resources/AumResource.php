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
    protected static ?string $model = Aum::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->label('Nama Aum')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('npsm')
                    ->label('NPSM')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamatAum')
                    ->label('Alamat Aum')
                    ->maxLength(255),
                Forms\Components\TextInput::make('teleponAum')
                    ->label('Telepon Aum')
                    ->maxLength(255),
                Forms\Components\TextInput::make('emailAum')
                    ->label('Email Aum')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('websiteAum')
                    ->label('Website Aum')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('logoAum')
                    ->label('Logo Aum')
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
                    ->label('Nama Aum')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npsm')
                    ->label('NPSM')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamatAum')
                    ->label('Alamat Aum')
                    ->limit(30),
                Tables\Columns\TextColumn::make('teleponAum')
                    ->label('Telepon Aum')
                    ->limit(20),
                Tables\Columns\TextColumn::make('emailAum')
                    ->label('Email Aum')
                    ->limit(30),
                Tables\Columns\TextColumn::make('websiteAum')
                    ->label('Website Aum')
                    ->limit(30),
                Tables\Columns\ImageColumn::make('logoAum')
                    ->label('Logo Aum')
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
