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
        Schema::create('competencies', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('category');
        $table->integer('duration'); // dalam menit
        $table->text('description');
        $table->boolean('is_available')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competencies');
    }
};
