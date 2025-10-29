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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // HND1, HND2, Bachelor
            $table->string('slug')->unique(); // hnd1, hnd2, bachelor
            $table->text('description')->nullable();
            $table->integer('order')->default(0); // For custom ordering
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
