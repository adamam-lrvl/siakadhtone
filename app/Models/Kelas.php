<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = ['kode_kelas', 'nama_kelas', 'wali_kelas_id', ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'kelas_id');
    }
}
