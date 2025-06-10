<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilePegawaiResource\Pages;
use App\Filament\Resources\ProfilePegawaiResource\RelationManagers;
use App\Models\Profile;
use App\Models\ProfilePegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfilePegawaiResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Profile Anggota';

    protected static ?string $modelLabel = 'Profile Anggota';
    protected static ?string $pluralModelLabel = 'Profile Anggota';

    public static function getLabel(): ?string
    {
        return 'Profile Anggota';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Profile Anggota';
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
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pegawaiAum.name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('noKTAM')->label('No. KTAM')->searchable(),
                Tables\Columns\TextColumn::make('noKTP')->label('No. KTP')->searchable(),
                Tables\Columns\TextColumn::make('noNIPY')->label('No. NIPY')->searchable(),
                Tables\Columns\TextColumn::make('tempatLahir')->label('Tempat Lahir')->searchable(),
                Tables\Columns\TextColumn::make('jenisKelamin')->label('Jenis Kelamin'),
                Tables\Columns\TextColumn::make('tanggalLahir')->label('Tanggal Lahir')->date(),
                Tables\Columns\IconColumn::make('isMarried')
                    ->label('Status Menikah')
                    ->boolean(),
                Tables\Columns\TextColumn::make('alamat')->label('Alamat')->limit(30),
                Tables\Columns\ImageColumn::make('fotoProfile')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('noTelp')->label('No. Telp'),
                Tables\Columns\TextColumn::make('totalMasaKerja')->label('Total Masa Kerja'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('id_aum')
                    ->label('AUM')
                    ->options(\App\Models\Aum::all()->pluck('namaAum', 'id'))
                    ->searchable(),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['pegawaiAum.name']);
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
            'index' => Pages\ListProfilePegawais::route('/'),
        ];
    }
}
