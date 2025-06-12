<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RiwayatPekerjaan extends Model
{
    use HasUuids;

    protected $table = 'riwayat_pekerjaan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'namaAum',
        'nomerAum',
        'namaPenandatangan',
        'jabatanPenandaTangan',
        'nomerSK',
        'masaKerjaDalamBulan',
        'tanggalSK',
        'buktiSK',
        'id_pegawai',
    ];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiAum::class, 'id_pegawai', 'id');
    }
}
