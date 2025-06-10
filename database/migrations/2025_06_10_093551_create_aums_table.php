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
        Schema::create('aum', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('namaAum');
            $table->string('npsm')->unique();
            $table->string('alamatAum')->nullable();
            $table->string('teleponAum')->nullable();
            $table->string('emailAum')->nullable();
            $table->string('websiteAum')->nullable();
            $table->string('logoAum')->nullable();
            $table->boolean('izinTambahPegawai')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aum');
    }
};
