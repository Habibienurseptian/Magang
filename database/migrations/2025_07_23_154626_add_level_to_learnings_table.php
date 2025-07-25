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
        Schema::table('learnings', function (Blueprint $table) {
            $table->string('level')->nullable()->after('title');
            // Bisa diisi: Pemula, Menengah, Mahir
        });
    }

    public function down(): void
    {
        Schema::table('learnings', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
};
