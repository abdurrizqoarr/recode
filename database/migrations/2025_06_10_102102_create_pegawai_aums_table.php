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
        Schema::create('pegawai_aum', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_aum');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('status', [
                'Pegawai Tetap Yayasan',
                'Guru Tetap Yayasan',
                'Pegawai Kontrak Yayasan',
                'Guru Kontrak Yayasan',
                'Guru Honor Sekolah',
                'Tenaga Honor Sekolah',
                'Guru Tamu'
            ]);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_aum')->references('id')->on('aum')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_aum');
    }
};
