<?php

namespace App\Filament\Resources;

use App\Filament\Exports\PendidikanFormalExporter;
use App\Filament\Resources\PendidikanFormalResource\Pages;
use App\Filament\Resources\PendidikanFormalResource\RelationManagers;
use App\Models\PendidikanFormal;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendidikanFormalResource extends Resource
{
    protected static ?string $model = PendidikanFormal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pendidikan Formal';

    protected static ?string $modelLabel = 'Pendidikan Formal';
    protected static ?string $pluralModelLabel = 'Pendidikan Formal';

    public static function getLabel(): ?string
    {
        return 'Pendidikan Formal';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Pendidikan Formal';
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
                    ->exporter(PendidikanFormalExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.name')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('pegawai.aum.namaAum')
                    ->label('Asal Aum')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tingkatPendidikan')
                    ->label('Tingkat Pendidikan')
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lembagaPendidikan')
                    ->label('Lembaga Pendidikan')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tahunLulus')
                    ->label('Tahun Lulus')
                    ->alignCenter()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ijazah')
                    ->alignCenter()
                    ->label('Ijazah')
                    ->formatStateUsing(fn($state) => $state ? 'Download' : '-')
                    ->url(fn($record) => $record->ijazah
                        ? route('download.document', ['filename' => $record->ijazah])
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
            'index' => Pages\ListPendidikanFormals::route('/'),
        ];
    }
}
