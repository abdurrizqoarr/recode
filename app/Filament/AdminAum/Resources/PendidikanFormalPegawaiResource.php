<?php

namespace App\Filament\AdminAum\Resources;

use App\Filament\AdminAum\Resources\PendidikanFormalPegawaiResource\Pages;
use App\Models\PendidikanFormal;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PendidikanFormalPegawaiResource extends Resource
{
    protected static ?string $model = PendidikanFormal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Pendidikan Formal Anggota';
    protected static ?string $pluralModelLabel = 'Pendidikan Formal Anggota';

    public static function getLabel(): ?string
    {
        return 'Pendidikan Formal Anggota';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Pendidikan Formal Anggota';
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
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
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.name')
                    ->label('Nama')
                    ->searchable(),

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
                //
            ])
            ->query(function () {
                $idAum = Auth::guard('admin-aums')->user()->id_aum;
                return PendidikanFormal::query()
                    ->whereHas('pegawai', function ($query) use ($idAum) {
                        $query->where('id_aum', $idAum);
                    });
            })
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
            'index' => Pages\ListPendidikanFormalPegawais::route('/'),
        ];
    }
}
