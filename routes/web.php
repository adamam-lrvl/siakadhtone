<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\Siswa\CbtController;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

// ================== LANDING ==================
Route::get('/', function () {
    $pengumuman = Pengumuman::where('aktif', true)
                             ->latest()
                             ->take(6)
                             ->get();
    return view('landing', compact('pengumuman'));
})->name('home');

// ================== DASHBOARD GATEWAY ==================
Route::get('/dashboard', function () {
    $user = Auth::user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guru'  => redirect()->route('guru.dashboard'),
        'siswa' => redirect()->route('siswa.dashboard'),
        default => redirect()->route('login'),
    };
})->middleware(['auth'])->name('dashboard');

// ================== ADMIN ==================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('mapel', MapelController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::resource('nilai', NilaiController::class)->only(['index', 'show']);
    Route::resource('absensi', AbsensiController::class)->only(['index', 'show']);
    Route::resource('soal', SoalController::class);
    Route::get('soal/preview/{paket}', [SoalController::class, 'preview'])->name('soal.preview');
    Route::resource('pengumuman', PengumumanController::class);
    Route::post('pengumuman/upload', [PengumumanController::class, 'upload'])
         ->name('pengumuman.upload');
});

// ================== GURU ==================
Route::prefix('guru')->name('guru.')->middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rekap-absensi', [AbsensiController::class, 'rekap'])->name('absensi.rekap');
    Route::get('/jadwal', [GuruDashboardController::class, 'index'])->name('jadwal.index');
    // ====== ABSENSI (tetap) ======
    Route::get('/absensi', [GuruAbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/{jadwal}/create', [GuruAbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi/{jadwal}', [GuruAbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{jadwal}/show', [GuruAbsensiController::class, 'show'])->name('absensi.show');
    Route::get('/absensi/{jadwal}/edit', [GuruAbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{jadwal}', [GuruAbsensiController::class, 'update'])->name('absensi.update');
    Route::get('/absensi/{jadwal}/export/excel', [GuruAbsensiController::class, 'exportExcel'])->name('absensi.export.excel');
    Route::get('/absensi/{jadwal}/export/pdf', [GuruAbsensiController::class, 'exportPdf'])->name('absensi.export.pdf');

    // ====== INPUT NILAI — SISTEM BARU (PER KATEGORI) ======
    Route::get('/nilai', [GuruNilaiController::class, 'index'])->name('nilai.index');

    // Pilih kategori (Tugas 1, UTS, dll)
    Route::get('/nilai/{kelas}/{mapel}/pilih-kategori', [GuruNilaiController::class, 'pilihKategori'])
        ->name('nilai.pilih-kategori');

    // Input nilai per kategori
    Route::get('/nilai/{kelas}/{mapel}/{kategori}', [GuruNilaiController::class, 'inputPerKategori'])
        ->name('nilai.input-kategori');

    // Simpan nilai per kategori
    Route::post('/nilai/{kelas}/{mapel}/{kategori}', [GuruNilaiController::class, 'simpanPerKategori'])
        ->name('nilai.simpan-kategori');

    Route::get('/nilai/{kelas}/{mapel}/rekap/{semester?}', [NilaiController::class, 'show'])
        ->name('nilai.show')
        ->defaults('semester', 1);
    // Route::get('nilai/{kelas}/{mapel}/edit', [GuruNilaiController::class, 'edit'])->name('nilai.edit');
    // Route::put('nilai/{kelas}/{mapel}', [GuruNilaiController::class, 'update'])->name('nilai.update');
});

// ================== SISWA ==================
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/nilai', [SiswaDashboardController::class, 'nilai'])->name('nilai');
    Route::get('/nilai/rekap', [SiswaDashboardController::class, 'rekap'])
        ->name('nilai.rekap');
    Route::get('/absensi', [SiswaDashboardController::class, 'absensi'])->name('absensi.index');
    Route::get('/jadwal', [SiswaDashboardController::class, 'jadwal'])->name('jadwal.index');
    Route::get('/pengumuman', [SiswaDashboardController::class, 'pengumuman'])->name('pengumuman.index');
    //Route::get('/cbt', [CbtController::class, 'index'])->name('cbt');
    //Route::get('/cbt/{soal}', [CbtController::class, 'kerjakan'])->name('cbt.kerjakan');
    //Route::post('/cbt/{soal}', [CbtController::class, 'submit'])->name('cbt.submit');
});

// ================== PROFILE (ALL ROLES) ==================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================== AUTH ==================
require __DIR__.'/auth.php';