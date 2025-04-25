<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPegawai extends Model
{
    use HasFactory;

    protected $table = 'jenis_pegawai';
    protected $primaryKey = 'id_jenis_pegawai';
    public $incrementing = true; // Karena auto_increment
    protected $keyType = 'int'; // Karena id_jenis_pegawai adalah integer
    protected $fillable = ['nama_jenis_pegawai'];

    public function profilPegawai()
    {
        return $this->hasMany(ProfilPegawai::class, 'id_jenis_pegawai', 'id_jenis_pegawai');
    }
}