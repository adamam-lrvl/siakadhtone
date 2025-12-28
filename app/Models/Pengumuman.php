<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $fillable = ['judul', 'isi', 'aktif', 'tanggal'];

    protected $casts = [
        'aktif' => 'boolean',
        'tanggal' => 'date',
    ];
}
