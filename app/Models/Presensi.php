<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $primaryKey = 'id_presensi';
    public $incrementing = true; // Karena auto_increment
    protected $keyType = 'int'; // Karena id_presensi adalah integer
    protected $fillable = [
        'id_profil_pegawai',
        'tanggal',
        'jam_masuk',
        'foto_masuk',
        'jam_keluar',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i:s',
        'jam_keluar' => 'datetime:H:i:s',
        'status' => 'string', // 'hadir', 'terlambat', 'izin', 'cuti'
    ];

    public function profilPegawai()
    {
        return $this->belongsTo(ProfilPegawai::class, 'id_profil_pegawai', 'id_profil_pegawai');
    }
}