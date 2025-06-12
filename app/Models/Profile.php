<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasUuids;

    protected $table = 'profile';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'noKTAM',
        'noKTP',
        'noNIPY',
        'tempatLahir',
        'jenisKelamin',
        'tanggalLahir',
        'isMarried',
        'alamat',
        'fotoProfile',
        'noTelp',
        'totalMasaKerja',
        'id_pegawai',
    ];

    public function pegawaiAum()
    {
        return $this->belongsTo(PegawaiAum::class, 'id_pegawai', 'id');
    }

    protected static function booted(): void
    {
        // Daftarkan sebuah event listener yang akan berjalan SEBELUM record dihapus.
        // Kita menggunakan "deleting" bukan "deleted".
        static::deleting(function (RiwayatPekerjaan $riwayatPekerjaan) {
            // Ambil profile terkait
            $profile = Profile::where('id_pegawai', $riwayatPekerjaan->id_pegawai)->first();

            // Jika profile ditemukan, kurangi total masa kerjanya
            if ($profile) {
                $profile->decrement('totalMasaKerja', $riwayatPekerjaan->masaKerjaDalamBulan);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'isMarried' => 'boolean',
        ];
    }
}
