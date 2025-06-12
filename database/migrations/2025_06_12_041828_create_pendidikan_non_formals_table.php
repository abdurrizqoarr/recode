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
        Schema::create('pendidikan_non_formal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('lembagaPenyelenggara');
            $table->string('namaKursus');
            $table->string('tingkat');
            $table->string('tahunLulus');
            $table->string('sertifikat')->nullable();
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
        Schema::dropIfExists('pendidikan_non_formal');
    }
};
