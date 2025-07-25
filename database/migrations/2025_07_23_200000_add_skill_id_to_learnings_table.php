<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('learnings', function (Blueprint $table) {
            $table->unsignedBigInteger('skill_id')->nullable()->after('id');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learnings', function (Blueprint $table) {
            $table->dropForeign(['skill_id']);
            $table->dropColumn('skill_id');
        });
    }
};
