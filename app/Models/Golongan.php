<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $table = 'golongan';
    protected $primaryKey = 'id_golongan';
    public $incrementing = true;
    protected $fillable = ['nama_golongan'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function profilPegawai()
    {
        return $this->hasMany(ProfilPegawai::class, 'id_golongan', 'id_golongan');
    }
}