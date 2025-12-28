<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketSoal extends Model
{
    protected $fillable = ['judul', 'mapel_id', 'kelas_id', 'durasi', 'aktif'];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }
}
