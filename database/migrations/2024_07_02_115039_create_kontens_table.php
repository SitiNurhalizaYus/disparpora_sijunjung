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
        Schema::create('kontens', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('slug')->nullable();
            $table->text('description_short')->nullable();
            $table->text('description_long')->nullable();
            $table->string('gambar', 255)->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->integer('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontens');
    }
};
