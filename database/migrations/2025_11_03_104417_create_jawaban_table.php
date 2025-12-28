<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')
                  ->constrained('siswa')
                  ->cascadeOnDelete();
            $table->foreignId('soal_id')
                  ->constrained('soal')
                  ->cascadeOnDelete();
            $table->char('jawaban_siswa', 1);
            $table->integer('nilai')->default(0);
            $table->timestamp('waktu_mulai');
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();

            $table->unique(['siswa_id', 'soal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
