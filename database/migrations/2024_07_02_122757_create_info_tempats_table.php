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
            $table->foreignId('id_agen')->constrained('agents')->onDelete('cascade');
            $table->foreignId('id_kategori')->constrained('kategoris')->onDelete('cascade');
            $table->string('nama', 100);
            $table->text('deskripsi');
            $table->text('fasilitas')->nullable();
            $table->string('jam_operasional', 50)->nullable();
            $table->decimal('harga_tiket', 10, 2)->nullable();
            $table->text('gambar')->nullable();
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
