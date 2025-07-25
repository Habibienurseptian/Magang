<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('competencies', function (Blueprint $table) {
            $table->unsignedBigInteger('skill_id')->nullable()->after('id');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('competencies', function (Blueprint $table) {
            $table->dropForeign(['skill_id']);
            $table->dropColumn('skill_id');
        });
    }
};
