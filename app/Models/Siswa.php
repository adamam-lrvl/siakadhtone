<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Siswa extends Model
{
    use LogsActivity;       
    use SoftDeletes;        

    protected $fillable = [
        'user_id',
        'nis',
        'nama',
        'kelas_id',
        'alamat',
        'telepon',
        'jenis_kelamin',
        'tanggal_lahir',
        'telepon_wali',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // LOG SEMUA FIELD YANG DI FILLABLE
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "Siswa baru ditambahkan: {$this->nama}",
                'updated' => "Data siswa diperbarui: {$this->nama}",
                'deleted' => "Siswa dihapus: {$this->nama}",
                default   => ucfirst($eventName) . " siswa: {$this->nama}"
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'siswa_id');
    }
}