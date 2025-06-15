<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TugasMapel extends Model
{
    use HasUuids;

    protected $table = 'tugas_mapel';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'mapelDiampu',
        'totalJamSeminggu',
        'id_pegawai',
    ];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiAum::class, 'id_pegawai', 'id');
    }
}
