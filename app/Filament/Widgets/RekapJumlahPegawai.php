<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class RekapJumlahPegawai extends ChartWidget
{
    protected int | string | array $columnSpan = "6";
    protected static ?string $heading = 'Jumlah Pegawai per AUM';

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getData(): array
    {
        // Hitung jumlah profil per AUM
        $data = DB::table('profile')
            ->join('pegawai_aum', 'profile.id_pegawai', '=', 'pegawai_aum.id')
            ->join('aum', 'pegawai_aum.id_aum', '=', 'aum.id')
            ->select('aum.id as aum_id', 'aum.namaAum', DB::raw('count(profile.id) as total_profiles'))
            ->groupBy('aum.id', 'aum.namaAum')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => $data->pluck('total_profiles')->toArray(),
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => $data->map(fn($item) => $item->namaAum ?? 'AUM #' . $item->aum_id)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
