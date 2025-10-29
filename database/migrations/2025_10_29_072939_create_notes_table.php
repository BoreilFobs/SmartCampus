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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->text('content')->nullable(); // Rich text content (HTML)
            $table->string('pdf_path')->nullable(); // Path to downloadable PDF summary
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // Admin who created
            $table->timestamps();
            
            // Indexes
            $table->index('video_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
