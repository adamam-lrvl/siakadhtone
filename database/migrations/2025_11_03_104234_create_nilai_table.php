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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')
                  ->constrained('siswa')
                  ->cascadeOnDelete();
            $table->foreignId('mapel_id')
                  ->constrained('mapels')
                  ->cascadeOnDelete();
            $table->decimal('nilai', 5, 2);
            $table->enum('semester', ['1','2']);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['siswa_id', 'mapel_id', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
