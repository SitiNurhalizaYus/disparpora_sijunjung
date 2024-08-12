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
        Schema::create('arsips', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->integer('year')->nullable(); // Tahun arsip
            $table->integer('year')->nullable(); // bulan arsip
            $table->foreignId('berita_id')->nullable();  
            $table->foreignId('artikel_id')->nullable();  
            $table->boolean('is_active')->default(1);
            $table->timestamps(); // Created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
