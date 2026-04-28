<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pengumuman extends Model
{
    use LogsActivity;
    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'tanggal',
        'aktif',
        'status',        
        'approved_by',   
        'approved_at',   
    ];

    protected $casts = [
        'tanggal'     => 'date',
        'aktif'       => 'boolean',
        'approved_at' => 'datetime',
    ];

    // Relasi ke user yang approve
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scope: hanya yang sudah approved & aktif (untuk tampil ke siswa)
    public function scopePublished($query)
    {
        return $query->where('status', 'approved')->where('aktif', true);
    }

    // Scope: pending (untuk list approval kepala sekolah)
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Activity log config
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'status', 'aktif'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Membuat pengumuman baru',
                'updated' => 'Memperbarui pengumuman',
                'deleted' => 'Menghapus pengumuman',
                default   => $eventName,
            });
    }
}