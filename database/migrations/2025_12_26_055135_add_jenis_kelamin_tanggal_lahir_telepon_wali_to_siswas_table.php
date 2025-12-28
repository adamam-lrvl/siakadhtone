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
        Schema::table('siswas', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['L', 'P'])->after('nama');
            $table->date('tanggal_lahir')->nullable()->after('jenis_kelamin');
            $table->string('telepon_wali', 15)->nullable()->after('telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin', 'tanggal_lahir', 'telepon_wali']);
        });
    }
};
