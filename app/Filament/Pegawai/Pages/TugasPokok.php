<?php

namespace App\Filament\Pegawai\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\TugasPokok as TugasPokokModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;

class TugasPokok extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pegawai.pages.tugas-pokok';

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Penugasan';

    public ?array $data = [];

    public $file = '';

    public function mount(): void
    {
        $user = Auth::guard('pegawais')->user();

        $tugasPokok = TugasPokokModel::where('id_pegawai', $user->id)->first();

        if ($tugasPokok) {
            $this->file = $tugasPokok->buktiSK;
            $this->form->fill($tugasPokok->toArray());
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                \Filament\Forms\Components\Section::make('Profil')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('tugasPokok')
                                ->label('Tugas Pokok')
                                ->disabled(),
                            TextInput::make('namaAum')
                                ->label('Nama AUM')
                                ->disabled(),
                            TextInput::make('nomerAum')
                                ->label('Nomor AUM')
                                ->disabled(),
                            TextInput::make('namaPenandatangan')
                                ->label('Nama Penandatangan')
                                ->disabled(),
                            TextInput::make('jabatanPenandaTangan')
                                ->label('Jabatan Penandatangan')
                                ->disabled(),
                            TextInput::make('nomerSK')
                                ->label('Nomor SK')
                                ->disabled(),
                            DatePicker::make('tanggalSK')
                                ->label('Tanggal SK')
                                ->disabled(),
                        ])
                    ])
            ]);
    }
}
