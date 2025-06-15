<?php

namespace App\Filament\Widgets;

use App\Models\Aum;
use App\Models\Profile;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CountProfilePerStatus extends ChartWidget
{
    protected int | string | array $columnSpan = "6";
    protected static ?string $heading = 'Jumlah Profile per Status dan AUM';

    protected function getColumns(): int
    {
        return 1; // Set the number of columns to 3
    }

    protected function getData(): array
    {
        // 1. Definisikan daftar status yang akan menjadi acuan
        // Ini memastikan urutan yang konsisten di dalam chart.
        $statusList = [
            'Pegawai Tetap Yayasan',
            'Guru Tetap Yayasan',
            'Pegawai Kontrak Yayasan',
            'Guru Kontrak Yayasan',
            'Guru Honor Sekolah',
            'Tenaga Honor Sekolah',
            'Guru Tamu',
        ];

        // 2. Ambil data mentah dari database menggunakan Eloquent/Query Builder.
        // Eloquent lebih disarankan jika relasi sudah didefinisikan.
        $rawData = Profile::query()
            ->join('pegawai_aum', 'profile.id_pegawai', '=', 'pegawai_aum.id')
            ->join('aum', 'pegawai_aum.id_aum', '=', 'aum.id')
            ->select(
                'aum.namaAum',
                'pegawai_aum.status',
                DB::raw('count(profile.id) as total')
            )
            ->groupBy('aum.namaAum', 'pegawai_aum.status')
            ->get();

        // 3. Proses data menggunakan Laravel Collection untuk membuat pivot table

        // Buat template status dengan nilai default 0
        $statusTemplate = array_fill_keys($statusList, 0);

        // Kelompokkan data berdasarkan nama AUM, lalu isi dengan data yang ada
        $rekap = $rawData
            ->groupBy('namaAum') // ->groupBy() dari collection
            ->map(function ($items) use ($statusTemplate) {
                // Konversi data per AUM menjadi [status => total]
                $aumStatusCounts = $items->pluck('total', 'status');
                // Gabungkan dengan template untuk memastikan semua status ada
                return array_merge($statusTemplate, $aumStatusCounts->all());
            });

        // Jika tidak ada data sama sekali, pastikan kita tetap memiliki struktur yang valid
        // Misalnya, tampilkan semua AUM yang ada dengan data nol.
        if ($rekap->isEmpty()) {
            $allAums = Aum::query()->pluck('namaAum');
            foreach ($allAums as $aumName) {
                $rekap[$aumName] = $statusTemplate;
            }
        }

        // 4. Siapkan data untuk format yang dibutuhkan Chart.js
        $labels = $rekap->keys()->toArray(); // Daftar nama AUM untuk sumbu-X
        $datasets = [];

        foreach ($statusList as $status) {
            $datasets[] = [
                'label' => $status,
                // Ambil data untuk setiap status dari semua AUM sesuai urutan label
                'data' => $rekap->pluck($status)->toArray(),
                'backgroundColor' => $this->getColorForStatus($status),
                'borderColor' => $this->getColorForStatus($status, true), // Opsional
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    /**
     * Helper function untuk memberikan warna yang konsisten untuk setiap status.
     *
     * @param string $status
     * @param bool $isBorder
     * @return string
     */
    private function getColorForStatus(string $status, bool $isBorder = false): string
    {
        $colors = [
            'Pegawai Tetap Yayasan' => 'rgba(54, 162, 235, ' . ($isBorder ? '1' : '0.7') . ')', // Blue
            'Guru Tetap Yayasan' => 'rgba(255, 99, 132, ' . ($isBorder ? '1' : '0.7') . ')', // Red
            'Pegawai Kontrak Yayasan' => 'rgba(75, 192, 192, ' . ($isBorder ? '1' : '0.7') . ')', // Green
            'Guru Kontrak Yayasan' => 'rgba(255, 159, 64, ' . ($isBorder ? '1' : '0.7') . ')', // Orange
            'Guru Honor Sekolah' => 'rgba(153, 102, 255, ' . ($isBorder ? '1' : '0.7') . ')', // Purple
            'Tenaga Honor Sekolah' => 'rgba(255, 205, 86, ' . ($isBorder ? '1' : '0.7') . ')', // Yellow
            'Guru Tamu' => 'rgba(201, 203, 207, ' . ($isBorder ? '1' : '0.7') . ')', // Grey
        ];

        // Kembalikan warna yang sesuai atau warna default jika tidak ditemukan
        return $colors[$status] ?? 'rgba(100, 100, 100, ' . ($isBorder ? '1' : '0.7') . ')';
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
