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
        Schema::create('izin', function (Blueprint $table) {
            $table->id('id_izin');  // ID unik untuk setiap izin
            $table->unsignedInteger('id_profil_pegawai');  // ID Profil Pegawai (INT biasa)
            $table->date('tanggal');  // Tanggal izin diajukan
            // $table->enum('jenis', ['sakit', 'cuti', 'izin']);  // Jenis izin
            $table->unsignedInteger('id_jenis_izin');  // ID Jenis Izin (INT biasa)
            $table->text('keterangan');  // Alasan atau penjelasan izin
            $table->string('lampiran')->nullable();  // Lampiran bukti izin, jika ada
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');  // Status izin
            $table->timestamps();  // Tanggal dan waktu pembuatan serta pembaruan

            // Constraint foreign key
            $table->foreign('id_profil_pegawai')->references('id_profil_pegawai')->on('profil_pegawai')->onDelete('cascade');
            // Jika profil_pegawai dihapus, izin terkait juga akan dihapus
            $table->foreign('id_jenis_izin')->references('id_jenis_izin')->on('jenis_izin')->onDelete('cascade');
            // Jika jenis_izin dihapus, izin terkait juga akan dihapus
        });
    }       

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
