<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Mapel extends Model
{
    use LogsActivity;

    protected $table = 'mapels';

    protected $fillable = [
        'kode',
        'nama_mapel',
        'kkm',
        'kategori',
    ];

    // LOG AKTIVITAS (opsional, biar muncul di dashboard admin)
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['kode', 'nama_mapel', 'kkm', 'kategori'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Mapel {$this->nama_mapel} " . 
                ($eventName === 'created' ? 'ditambahkan' : 
                 ($eventName === 'updated' ? 'diperbarui' : 'dihapus')));
    }

    // RELASI JADWAL (1 MAPEL BISA PUNYA BANYAK JADWAL)
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'mapel_id');
    }

    // RELASI NILAI (1 MAPEL BISA PUNYA BANYAK NILAI)
    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'mapel_id');
    }

    // RELASI SOAL (1 MAPEL BISA PUNYA BANYAK SOAL)
    public function soals()
    {
        return $this->hasMany(Soal::class, 'mapel_id');
    }

    // RELASI GURU (1 MAPEL BISA DIAJAR OLEH BANYAK GURU — MANY-TO-MANY)
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel', 'mapel_id', 'guru_id')
                    ->withTimestamps();
    }

    // RELASI KELAS (1 MAPEL BISA DIAJARKAN DI BANYAK KELAS — MANY-TO-MANY VIA JADWAL)
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'jadwals', 'mapel_id', 'kelas_id')
                    ->withTimestamps()
                    ->withPivot('hari', 'jam_mulai', 'jam_selesai', 'guru_id');
    }
}