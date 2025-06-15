<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TugasPokok extends Model
{
    use HasUuids;

    protected $table = 'tugas_pokok';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tugasPokok',
        'namaAum',
        'nomerAum',
        'namaPenandatangan',
        'jabatanPenandaTangan',
        'nomerSK',
        'tanggalSK',
        'buktiSK',
        'id_pegawai',
    ];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiAum::class, 'id_pegawai', 'id');
    }
}
