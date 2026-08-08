<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->unique(['siswa_id', 'mapel_id', 'semester', 'kategori'], 'nilai_siswa_mapel_semester_kategori_unique');
        });

        Schema::table('nilais', function (Blueprint $table) {
            $table->dropUnique('nilai_siswa_id_mapel_id_semester_unique');
        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->unique(['siswa_id', 'mapel_id', 'semester'], 'nilai_siswa_id_mapel_id_semester_unique');
        });

        Schema::table('nilais', function (Blueprint $table) {
            $table->dropUnique('nilai_siswa_mapel_semester_kategori_unique');
        });
    }
};
