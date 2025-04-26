<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    
    protected $primaryKey = 'id_jadwal';
    public $incrementing = true; // Karena auto_increment
    protected $keyType = 'int'; // Karena id_jenis_izin adalah integer
    protected $fillable = [
        'tanggal', 
        'status', 
        'keterangan'
    ];
    protected $dates = 
    ['tanggal'
    ];
}