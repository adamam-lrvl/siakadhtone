<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Nilai extends Model
{
    use LogsActivity;

    protected $fillable = ['siswa_id', 'mapel_id', 'nilai', 'semester', 'keterangan', 'kategori'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['siswa_id', 'mapel_id', 'nilai', 'semester', 'kategori'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Input nilai siswa',
                'updated' => 'Update nilai siswa',
                'deleted' => 'Hapus nilai siswa',
                default   => ucfirst($eventName) . ' nilai',
            });
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}