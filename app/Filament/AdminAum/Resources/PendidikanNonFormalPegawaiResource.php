<?php

namespace App\Filament\AdminAum\Resources;

use App\Filament\AdminAum\Resources\PendidikanNonFormalPegawaiResource\Pages;
use App\Models\PendidikanNonFormal;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PendidikanNonFormalPegawaiResource extends Resource
{
    protected static ?string $model = PendidikanNonFormal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Pendidikan Formal Non Anggota';
    protected static ?string $pluralModelLabel = 'Pendidikan Non Formal Anggota';

    public static function getLabel(): ?string
    {
        return 'Pendidikan Non Formal Anggota';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Pendidikan Non Formal Anggota';
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
                Tables\Columns\TextColumn::make('pegawai.name')->label('Nama')->searchable(),
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
                //
            ])
            ->query(function () {
                $idAum = Auth::guard('admin-aums')->user()->id_aum;
                return PendidikanNonFormal::query()
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
            'index' => Pages\ListPendidikanNonFormalPegawais::route('/'),
        ];
    }
}
