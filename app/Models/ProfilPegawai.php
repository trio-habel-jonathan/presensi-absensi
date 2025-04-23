<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPegawai extends Model
{
    use HasFactory;

    protected $table = 'profil_pegawai';
    protected $primaryKey = 'id_profil_pegawai';
    public $incrementing = true;
    protected $fillable = [
        'nama_pegawai',
        'no_identitas',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'id_jenis_pegawai',
        'id_golongan',
        'id_user',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'jenis_kelamin' => 'string', // 'L' or 'P'
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function jenisPegawai()
    {
        return $this->belongsTo(JenisPegawai::class, 'id_jenis_pegawai', 'id_jenis_pegawai');
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'id_golongan', 'id_golongan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'id_profil_pegawai', 'id_profil_pegawai');
    }

    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_profil_pegawai', 'id_profil_pegawai');
    }
}