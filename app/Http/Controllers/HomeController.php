<?php

namespace App\Http\Controllers;

use App\Models\Aum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $aum = Aum::orderBy('namaAum', 'asc')->get();
        return view('home', ['aum' => $aum]);
    }

    public function rekapAum(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idaum' => ['required', 'uuid', 'exists:aum,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'ID AUM tidak valid atau tidak ditemukan'], 400);
        }

        $statusList = [
            'Pegawai Tetap Yayasan',
            'Guru Tetap Yayasan',
            'Pegawai Kontrak Yayasan',
            'Guru Kontrak Yayasan',
            'Guru Honor Sekolah',
            'Tenaga Honor Sekolah',
            'Guru Tamu',
        ];

        $idAum = $request->query('idaum');
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

        return response()->json([
            'labels' => $statusList,
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => $formattedData,
                    'backgroundColor' => '#3b82f6',
                ],
            ],
        ]);
    }
}
