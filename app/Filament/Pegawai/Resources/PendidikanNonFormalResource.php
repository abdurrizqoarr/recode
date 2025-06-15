<?php

namespace App\Filament\Pegawai\Resources;

use App\Filament\Pegawai\Resources\PendidikanNonFormalResource\Pages;
use App\Filament\Pegawai\Resources\PendidikanNonFormalResource\RelationManagers;
use App\Models\PendidikanNonFormal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PendidikanNonFormalResource extends Resource
{
    protected static ?string $model = PendidikanNonFormal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('lembagaPenyelenggara')
                    ->label('Lembaga Penyelenggara')
                    ->required()
                    ->minLength(5)
                    ->maxLength(255),
                Forms\Components\TextInput::make('namaKursus')
                    ->label('Nama Kursus')
                    ->required()
                    ->minLength(5)
                    ->maxLength(255),
                Forms\Components\TextInput::make('tingkat')
                    ->label('Tingkat')
                    ->required()
                    ->minLength(5)
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahunLulus')
                    ->label('Tahun Lulus')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y'))
                    ->required(),
                Forms\Components\FileUpload::make('sertifikat')
                    ->label('Sertifikat')
                    ->disk('local')
                    ->directory('sertifikat')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(4096) // dalam kilobyte, 4096 KB = 4 MB
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            ->query(function () {
                $idUser = Auth::guard('pegawais')->id();
                return PendidikanNonFormal::query()->where('id_pegawai', $idUser);
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendidikanNonFormals::route('/'),
            'create' => Pages\CreatePendidikanNonFormal::route('/create'),
            'edit' => Pages\EditPendidikanNonFormal::route('/{record}/edit'),
        ];
    }
}
