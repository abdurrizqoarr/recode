<?php

namespace App\Filament\AdminAum\Resources;

use App\Filament\AdminAum\Resources\ProfilePegawaiResource\Pages;
use App\Filament\AdminAum\Resources\ProfilePegawaiResource\RelationManagers;
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
use Illuminate\Support\Facades\Auth;

class ProfilePegawaiResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pegawai')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('noKTAM')
                    ->label('No. KTAM')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('noKTP')
                    ->label('No. KTP')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('noNIPY')
                    ->label('No. NIPY')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('tempatLahir')
                    ->label('Tempat Lahir')
                    ->required(),
                Forms\Components\Select::make('jenisKelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki - Laki' => 'Laki - Laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('tanggalLahir')
                    ->label('Tanggal Lahir')
                    ->required(),
                Forms\Components\Radio::make('isMarried')
                    ->label('Status Menikah')
                    ->options([
                        1 => 'Menikah',
                        0 => 'Belum Menikah',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat')
                    ->required(),
                Forms\Components\FileUpload::make('fotoProfile')
                    ->label('Foto')
                    ->image()
                    ->directory('profile-photos')
                    ->imageCropAspectRatio('1:1')
                    ->imagePreviewHeight('100')
                    ->maxSize(2048),
                Forms\Components\TextInput::make('noTelp')
                    ->label('No. Telp'),
                Forms\Components\TextInput::make('totalMasaKerja')
                    ->label('Total Masa Kerja')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pegawaiAum.name')->label('Nama Anggota')->searchable(),
                Tables\Columns\TextColumn::make('noKTAM')->label('No. KTAM')->searchable(),
                Tables\Columns\TextColumn::make('noKTP')->label('No. KTP')->searchable(),
                Tables\Columns\TextColumn::make('noNIPY')->label('No. NIPY')->searchable(),
                Tables\Columns\TextColumn::make('tempatLahir')->label('Tempat Lahir')->searchable(),
                Tables\Columns\TextColumn::make('jenisKelamin')->label('Jenis Kelamin'),
                Tables\Columns\TextColumn::make('tanggalLahir')->label('Tanggal Lahir')->date(),
                Tables\Columns\IconColumn::make('isMarried')
                    ->label('Status Menikah')
                    ->boolean(),
                Tables\Columns\TextColumn::make('alamat')->label('Alamat')->limit(50),
                Tables\Columns\ImageColumn::make('fotoProfile')->label('Foto')->circular()->size(50),
                Tables\Columns\TextColumn::make('noTelp')->label('No. Telp'),
                Tables\Columns\TextColumn::make('totalMasaKerja')->label('Total Masa Kerja'),
            ])
            ->query(function () {
                $idAum = Auth::guard('admin-aums')->user()->id_aum;
                return Profile::query()
                    ->whereHas('pegawaiAum', function ($query) use ($idAum) {
                        $query->where('id_aum', $idAum);
                    });
            })
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['pegawaiAum']);
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
            'view' => Pages\DetailProfileAnggota::route('/{record}'),
        ];
    }
}
