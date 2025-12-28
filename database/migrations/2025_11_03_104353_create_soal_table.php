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
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_soal_id')
                  ->constrained('paket_soals')
                  ->onDelete('cascade');

            $table->foreignId('mapel_id')
                  ->constrained('mapels')
                  ->onDelete('cascade');

            $table->text('pertanyaan');
            $table->enum('tipe', ['pg', 'essay'])->default('pg');
            $table->json('pilihan')->nullable(); // JSON: {"a":"", "b":"", "c":"", "d":""}
            $table->string('jawaban')->nullable(); // a/b/c/d untuk PG, null untuk essay
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
