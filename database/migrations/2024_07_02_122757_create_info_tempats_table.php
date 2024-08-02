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
        Schema::create('info_tempats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agen_id')->constrained('agents')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('nama', 100);
            $table->text('deskripsi');
            $table->text('fasilitas')->nullable();
            $table->string('jam_operasional', 50)->nullable();
            $table->string('harga_tiket', 50)->nullable();
            $table->text('gambar')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_tempats');
    }
};
