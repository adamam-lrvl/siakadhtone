<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Absensi extends Model
{
    use LogsActivity;

    protected $fillable = ['siswa_id', 'jadwal_id', 'tanggal', 'status'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['siswa_id', 'jadwal_id', 'tanggal', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Input absensi siswa',
                'updated' => 'Edit absensi siswa',
                'deleted' => 'Hapus absensi siswa',
                default   => ucfirst($eventName) . ' absensi',
            });
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}