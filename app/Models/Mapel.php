<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapels';
    protected $fillable = ['kode', 'nama_mapel', 'kkm', 'kategori'];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }

        public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'jadwals', 'mapel_id', 'kelas_id');
    }
}
