<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PendidikanNonFormal extends Model
{
    use HasUuids;

    protected $table = 'pendidikan_non_formal';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'lembagaPenyelenggara',
        'namaKursus',
        'tingkat',
        'tahunLulus',
        'sertifikat',
        'id_pegawai',
    ];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiAum::class, 'id_pegawai', 'id');
    }
}
