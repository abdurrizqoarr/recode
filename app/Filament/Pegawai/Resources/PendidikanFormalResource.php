<?php

namespace App\Filament\Pegawai\Resources;

use App\Filament\Pegawai\Resources\PendidikanFormalResource\Pages;
use App\Models\PendidikanFormal;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PendidikanFormalResource extends Resource
{
    protected static ?string $model = PendidikanFormal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tingkatPendidikan')
                    ->label('Tingkat Pendidikan')
                    ->options([
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA' => 'SMA',
                        'D1' => 'D1',
                        'D2' => 'D2',
                        'D3' => 'D3',
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('lembagaPendidikan')
                    ->label('Lembaga Pendidikan')
                    ->minLength(5)
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('tahunLulus')
                    ->label('Tahun Lulus')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y'))
                    ->required(),

                Forms\Components\FileUpload::make('ijazah')
                    ->label('Ijazah')
                    ->disk('local')
                    ->directory('ijazah')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(4096) // dalam kilobyte, 4096 KB = 4 MB
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            ->query(function () {
                $idUser = Auth::guard('pegawais')->id();
                return PendidikanFormal::query()->where('id_pegawai', $idUser);
            })
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
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
            'create' => Pages\CreatePendidikanFormal::route('/create'),
            'edit' => Pages\EditPendidikanFormal::route('/{record}/edit'),
        ];
    }
}
