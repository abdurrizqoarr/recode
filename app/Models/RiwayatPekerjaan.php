<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RiwayatPekerjaan extends Model
{
    use HasUuids;

    protected $table = 'riwayat_pekerjaan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'namaAum',
        'nomerAum',
        'namaPenandatangan',
        'jabatanPenandaTangan',
        'nomerSK',
        'masaKerjaDalamBulan',
        'tanggalSK',
        'buktiSK',
        'id_pegawai',
    ];

    public function pegawai()
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
}
