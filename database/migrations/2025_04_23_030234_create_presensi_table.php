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
        Schema::create('presensi', function (Blueprint $table) {
            $table->increments('id_presensi');
            $table->unsignedInteger('id_profil_pegawai'); // Menggunakan INT sebagai foreign key
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->string('foto_masuk');
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['hadir', 'terlambat', 'izin', 'cuti'])->default('hadir');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_profil_pegawai')->references('id_profil_pegawai')->on('profil_pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
