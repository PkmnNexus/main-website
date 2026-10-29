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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->string('key')->unique();

            $table->foreignId('hero_asset_id')->nullable()->constrained('assets')->nullOnDelete();

            // routing
            $table->string('page')->unique();
            $table->json('slug');

            // content
            $table->json('content');

            // SEO
            $table->json('title');
            $table->json('meta_description');
            $table->json('meta_keywords');
            $table->json('canonical')->nullable();
            $table->boolean('robots_index')->default(true);
            $table->boolean('robots_follow')->default(true);

            // Open Graph
            $table->json('og_title')->nullable();
            $table->json('og_description')->nullable();
            $table->string('og_type')->default('website');

            // control
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};