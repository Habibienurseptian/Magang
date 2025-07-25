<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competency_id');
            $table->text('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->string('answer_key');
            $table->timestamps();

            $table->foreign('competency_id')->references('id')->on('competencies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('soals');
    }
};
