<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PegawaiAum extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $table = 'pegawai_aum';

    protected $fillable = [
        'id_aum',
        'name',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function aum()
    {
        return $this->belongsTo(Aum::class, 'id_aum');
    }
}
