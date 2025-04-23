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
        Schema::create('profil_pegawai', function (Blueprint $table) {
            $table->increments('id_profil_pegawai');
            $table->string('nama_pegawai');
            $table->string('no_identitas')->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('alamat');
            $table->string('no_telepon');
            
            // Menyebutkan nama tabel dengan eksplisit
            $table->unsignedInteger('id_jenis_pegawai')->nullable();
            // Menggunakan nullable() untuk foreign key
            $table->foreign('id_jenis_pegawai')->references('id_jenis_pegawai')->on('jenis_pegawai')->onDelete('cascade');
            
            $table->unsignedInteger('id_golongan')->nullable();
            // Menggunakan nullable() untuk foreign key
            $table->foreign('id_golongan')->references('id_golongan')->on('golongan')->onDelete('cascade');
            
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_pegawai');
    }
};
