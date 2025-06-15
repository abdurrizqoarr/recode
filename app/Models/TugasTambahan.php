<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TugasTambahan extends Model
{
    use HasUuids;

    protected $table = 'tugas_tambahan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tugasTambahan',
        'id_pegawai',
    ];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiAum::class, 'id_pegawai', 'id');
    }
}
