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
        'mapel_id',
    ];

    // LOG AKTIVITAS (biar muncul di dashboard admin)
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'nip', 'email', 'mapel_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Guru {$this->nama} " . 
                ($eventName === 'created' ? 'ditambahkan' : 
                 ($eventName === 'updated' ? 'diperbarui' : 'dihapus')));
    }

    // RELASI
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi jadwal (biar guru bisa liat jadwal mengajar)
    public function jadwalMengajar()
    {
        return $this->hasMany(Jadwal::class, 'guru_id');
    }
}