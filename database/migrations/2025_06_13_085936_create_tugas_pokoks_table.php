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
        Schema::create('tugas_pokok', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tugasPokok');
            $table->string('namaAum');
            $table->string('nomerAum');
            $table->string('namaPenandatangan');
            $table->string('jabatanPenandaTangan');
            $table->string('nomerSK');
            $table->date('tanggalSK');
            $table->string('buktiSK');
            $table->uuid('id_pegawai')->unique(true);

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
        Schema::dropIfExists('tugas_pokok');
    }
};
