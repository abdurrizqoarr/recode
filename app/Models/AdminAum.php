<?php

namespace App\Models;

use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Notifications\Notifiable;

class AdminAum extends Authenticatable implements FilamentUser
{
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

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
