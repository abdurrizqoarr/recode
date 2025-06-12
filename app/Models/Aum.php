<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aum extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'aum';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'namaAum',
        'npsm',
        'alamatAum',
        'teleponAum',
        'emailAum',
        'websiteAum',
        'logoAum',
        'izinTambahPegawai',
    ];

    protected function casts(): array
    {
        return [
            'izinTambahPegawai' => 'boolean',
        ];
    }
}
