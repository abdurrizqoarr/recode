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
        Schema::create('tugas_mapel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('mapelDiampu');
            $table->integer('totalJamSeminggu');
            $table->uuid('id_pegawai');

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
        Schema::dropIfExists('tugas_mapel');
    }
};
