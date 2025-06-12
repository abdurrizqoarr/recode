<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_pekerjaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('namaAum');
            $table->string('nomerAum');
            $table->string('namaPenandatangan');
            $table->string('jabatanPenandaTangan');
            $table->string('nomerSK');
            $table->integer('masaKerjaDalamBulan');
            $table->date('tanggalSK');
            $table->string('buktiSK');
            $table->uuid('id_pegawai')->unique();

            $table->timestamps();

            $table->foreign('id_pegawai')
                ->references('id')
                ->on('pegawai_aum')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pekerjaan');
    }
};
