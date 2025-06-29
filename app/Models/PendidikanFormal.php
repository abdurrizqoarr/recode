<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PendidikanFormal extends Model
{
    use HasUuids;
    
    protected $table = 'pendidikan_formal';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tingkatPendidikan',
        'lembagaPendidikan',
        'tahunLulus',
        'ijazah',
        'id_pegawai',
    ];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiAum::class, 'id_pegawai', 'id');
    }
}
