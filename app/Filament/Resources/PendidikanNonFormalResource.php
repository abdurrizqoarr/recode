<?php

namespace App\Filament\Resources;

use App\Filament\Exports\PendidikanNonFormalExporter;
use App\Filament\Resources\PendidikanNonFormalResource\Pages;
use App\Models\PendidikanNonFormal;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PendidikanNonFormalResource extends Resource
{
    protected static ?string $model = PendidikanNonFormal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pendidikan Non Formal';

    protected static ?string $modelLabel = 'Pendidikan Non Formal';
    protected static ?string $pluralModelLabel = 'Pendidikan Non Formal';

    public static function getLabel(): ?string
    {
        return 'Pendidikan Non Formal';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Pendidikan Non Formal';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false; // Disable editing for this resource
    }

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
            ->headerActions([
                ExportAction::make()
                    ->exporter(PendidikanNonFormalExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('pegawai.aum.namaAum')->label('Asal AUM')->sortable(),
                Tables\Columns\TextColumn::make('lembagaPenyelenggara')->label('Lembaga Penyelenggara')->searchable(),
                Tables\Columns\TextColumn::make('namaKursus')->label('Nama Kursus')->searchable(),
                Tables\Columns\TextColumn::make('tingkat')->label('Tingkat'),
                Tables\Columns\TextColumn::make('tahunLulus')->label('Tahun Lulus')->sortable(),
                Tables\Columns\TextColumn::make('sertifikat')
                    ->alignCenter()
                    ->label('Sertifikat')
                    ->formatStateUsing(fn($state) => $state ? 'Download' : '-')
                    ->url(fn($record) => $record->sertifikat
                        ? route('download.document', ['filename' => $record->sertifikat])
                        : null)
                    ->openUrlInNewTab()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('aum')
                    ->label('AUM')
                    ->relationship('pegawai.aum', 'namaAum')
                    ->options(\App\Models\Aum::all()->pluck('namaAum', 'id'))
                    ->searchable()
            ])
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
            'index' => Pages\ListPendidikanNonFormals::route('/'),
        ];
    }
}
