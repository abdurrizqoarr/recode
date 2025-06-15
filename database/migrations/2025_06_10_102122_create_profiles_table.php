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
        Schema::create('profile', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('noKTAM')->nullable(true);
            $table->string('noKTP')->nullable(true);
            $table->string('noNIPY')->nullable(true);
            $table->string('tempatLahir');
            $table->enum('jenisKelamin', ['Laki - Laki', 'Perempuan']);
            $table->date('tanggalLahir');
            $table->boolean('isMarried');
            $table->text('alamat');
            $table->string('fotoProfile')->nullable();
            $table->string('noTelp')->nullable();
            $table->integer('totalMasaKerja')->default(0);
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
        Schema::dropIfExists('profile');
    }
};
