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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_path'); // Path to video file on VPS server
            $table->string('thumbnail_path')->nullable(); // Auto-generated thumbnail
            $table->unsignedBigInteger('file_size')->nullable(); // File size in bytes
            $table->integer('duration')->nullable(); // Duration in seconds (extracted via FFmpeg)
            $table->integer('order')->default(0); // Order within course playlist
            $table->boolean('is_active')->default(true);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null'); // Admin who uploaded
            $table->timestamps();
            
            // Indexes
            $table->index('course_id');
            $table->index('is_active');
            $table->index(['course_id', 'order']); // Composite index for playlist ordering
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
