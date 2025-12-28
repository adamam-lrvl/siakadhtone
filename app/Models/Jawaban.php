<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $fillable = [
        'siswa_id', 'soal_id', 'jawaban_siswa', 'nilai',
        'waktu_mulai', 'waktu_selesai'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
