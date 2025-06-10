<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminAum extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $table = 'admin_aum';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'id_aum',
        'name',
        'username',
        'password',
        'remember_token',
    ];

    public function aum()
    {
        return $this->belongsTo(Aum::class, 'id_aum');
    }
}
