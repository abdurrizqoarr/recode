<?php

namespace App\Filament\AdminAum\Widgets;

use App\Models\Profile;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CountProfilePerStatus extends ChartWidget
{
    protected int | string | array $columnSpan = "12";
    protected static ?string $heading = 'Jumlah Profile per Status';

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }


    protected function getData(): array
    {
        $statusList = [
            'Pegawai Tetap Yayasan',
            'Guru Tetap Yayasan',
            'Pegawai Kontrak Yayasan',
            'Guru Kontrak Yayasan',
            'Guru Honor Sekolah',
            'Tenaga Honor Sekolah',
            'Guru Tamu',
        ];

        $idAum = Auth::guard('admin-aums')->user()->id_aum;
        $data = DB::table('profile')
            ->join('pegawai_aum', 'profile.id_pegawai', '=', 'pegawai_aum.id')
            ->where('pegawai_aum.id_aum', $idAum)
            ->select('pegawai_aum.status', DB::raw('count(profile.id) as total'))
            ->groupBy('pegawai_aum.status')
            ->get()
            ->pluck('total', 'status')->toArray();

        // Lengkapi status yang kosong (isi 0 jika tidak ada)
        $formattedData = [];
        foreach ($statusList as $status) {
            $formattedData[] = $data[$status] ?? 0;
        }

        return [
            'labels' => $statusList,
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => $formattedData,
                    'backgroundColor' => '#3b82f6',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
