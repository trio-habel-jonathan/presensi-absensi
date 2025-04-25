<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'izin';
    protected $primaryKey = 'id_izin';
    protected $fillable = [
        'id_profil_pegawai',
        'tanggal',
        'id_jenis_izin',
        'keterangan',
        'lampiran',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'status' => 'string', // 'pending', 'disetujui', 'ditolak'
    ];

    public function profilPegawai()
    {
        return $this->belongsTo(ProfilPegawai::class, 'id_profil_pegawai', 'id_profil_pegawai');
    }
    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class, 'id_jenis_izin', 'id_jenis_izin');
    }
}