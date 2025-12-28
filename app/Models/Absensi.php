<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = ['siswa_id', 'jadwal_id', 'tanggal', 'status'];

    protected $casts = [
        'tanggal' => 'date', 
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}
