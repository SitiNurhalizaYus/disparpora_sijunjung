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
        Schema::create('surveis', function (Blueprint $table) {
            $table->id();
            $table->text('pertanyaan');
            $table->string('pilihan_1', 255);
            $table->string('pilihan_2', 255);
            $table->string('pilihan_3', 255)->nullable();
            $table->string('pilihan_4', 255)->nullable();
            $table->integer('total_pilihan_1')->default(0);
            $table->integer('total_pilihan_2')->default(0);
            $table->integer('total_pilihan_3')->default(0);
            $table->integer('total_pilihan_4')->default(0);
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveis');
    }
};
