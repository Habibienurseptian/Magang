<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke user
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Relasi ke competency (uji kompetensi) - nama kolom harus competency_id
            $table->foreignId('competency_id')
                  ->nullable()
                  ->constrained('competencies')
                  ->nullOnDelete(); // set null jika competency dihapus

            $table->string('certificate_url')->nullable();  // link file sertifikat (PDF)
            $table->timestamp('completed_at')->nullable();  // tanggal selesai ujian
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
