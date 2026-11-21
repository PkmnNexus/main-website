<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_scripts', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            // A script can be used on multiple platforms.
            $table->json('platforms');

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('video_script_categories')
                ->nullOnDelete();

            // Complete English script content with HTML formatting.
            $table->longText('content');

            // Automatically calculated from the English content.
            $table->unsignedInteger('word_count')->default(0);
            $table->unsignedInteger('estimated_duration')->default(0);

            // Desired video duration, stored in seconds.
            $table->unsignedInteger('target_duration')->nullable();

            $table->string('status', 30)->default('draft');

            $table->timestamp('published_at')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_scripts');
    }
};