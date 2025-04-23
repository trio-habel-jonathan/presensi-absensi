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
        'jenis',
        'keterangan',
        'lampiran',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jenis' => 'string', // 'sakit', 'cuti', 'izin'
        'status' => 'string', // 'pending', 'disetujui', 'ditolak'
    ];

    public function profilPegawai()
    {
        return $this->belongsTo(ProfilPegawai::class, 'id_profil_pegawai', 'id_profil_pegawai');
    }
}