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
            $table->integer('watch_limit_minutes')->default(0)->after('youtube_url'); // default 0 berarti tidak dibatasi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learnings', function (Blueprint $table) {
            //
        });
    }
};
