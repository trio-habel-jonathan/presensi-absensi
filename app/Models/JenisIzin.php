<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisIzin extends Model
{
    protected $table = 'jenis_izin';
    protected $primaryKey = 'id_jenis_izin';
    public $incrementing = true; // Karena auto_increment
    protected $keyType = 'int'; // Karena id_jenis_izin adalah integer
    protected $fillable = [
        'nama_jenis_izin'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_jenis_izin', 'id_jenis_izin');
    }
}
