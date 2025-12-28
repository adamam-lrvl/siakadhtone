<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_soal_id',
        'mapel_id',
        'pertanyaan',
        'tipe',
        'pilihan',
        'jawaban',
    ];

    protected $casts = [
        'pilihan' => 'array', // otomatis decode/encode JSON ke array PHP
    ];

    /**
     * Relasi ke Paket Soal
     */
    public function paketSoal()
    {
        return $this->belongsTo(PaketSoal::class);
    }

    /**
     * Relasi ke Mapel
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}
