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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key bigint(20)
            $table->foreignId('role_id');
            $table->string('username')->unique(); 
            $table->string('password'); 
            $table->string('name'); 
            $table->string('email')->unique(); 
            $table->string('picture')->nullable(); 
            $table->timestamp('last_login')->nullable(); 
            $table->timestamp('email_verified_at')->nullable(); 
            $table->rememberToken(); 
            $table->text('notes')->nullable(); 
            $table->boolean('is_active')->default(1); 
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
        Schema::dropIfExists('users');
    }
};
