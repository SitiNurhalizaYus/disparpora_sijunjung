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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_agen')->nullable()->constrained('agents')->onDelete('cascade');
            $table->foreignId('id_admin')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nama_acara', 100);
            $table->date('tanggal_acara');
            $table->text('deskripsi');
            $table->string('gambar', 255)->nullable();
            $table->string('link_event', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
