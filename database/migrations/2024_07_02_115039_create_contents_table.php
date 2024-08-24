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
        Schema::create('contents', function (Blueprint $table) {
            $table->id('id_content');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->text('description_short')->nullable();
            $table->string('image')->nullable();
            $table->enum('type', ['berita', 'artikel', 'profil']);
            $table->foreignId('category_id')->nullable();
            $table->foreignId('arsip_id')->nullable();
            // default
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
