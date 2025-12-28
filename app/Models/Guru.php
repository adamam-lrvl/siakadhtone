<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'gurus';

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'email',
        'telepon',
        'alamat',
    ];

    // LOG AKTIVITAS
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'nip', 'email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Guru {$this->nama} " . 
                ($eventName === 'created' ? 'ditambahkan' : 
                 ($eventName === 'updated' ? 'diperbarui' : 'dihapus')));
    }

    // RELASI USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // RELASI MAPEL — 1 GURU BISA NGAJAR BANYAK MAPEL (MANY-TO-MANY)
    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'guru_id', 'mapel_id')
                    ->withTimestamps();
    }

    // RELASI JADWAL MENGAJAR
    public function jadwalMengajar()
    {
        return $this->hasMany(Jadwal::class, 'guru_id');
    }
}