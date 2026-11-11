<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pokemon_tcg_cards', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            $table->foreignId('set_id')
                ->constrained('pokemon_tcg_sets')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | API Identification
            |--------------------------------------------------------------------------
            */

            $table->string('external_id')->unique();
            $table->string('api_local_id');
            $table->string('api_name');

            /*
            |--------------------------------------------------------------------------
            | API General Information
            |--------------------------------------------------------------------------
            */

            $table->text('api_image_url')->nullable();
            $table->string('api_category')->nullable();
            $table->string('api_illustrator')->nullable();
            $table->string('api_rarity')->nullable();

            /*
            |--------------------------------------------------------------------------
            | API Pokémon Information
            |--------------------------------------------------------------------------
            */

            $table->unsignedSmallInteger('api_hp')->nullable();
            $table->json('api_types')->nullable();
            $table->json('api_dex_ids')->nullable();
            $table->string('api_evolve_from')->nullable();
            $table->text('api_description')->nullable();
            $table->string('api_level')->nullable();
            $table->string('api_stage')->nullable();
            $table->string('api_suffix')->nullable();

            /*
            |--------------------------------------------------------------------------
            | API Trainer and Energy Information
            |--------------------------------------------------------------------------
            */

            $table->string('api_trainer_type')->nullable();
            $table->string('api_energy_type')->nullable();
            $table->text('api_effect')->nullable();

            /*
            |--------------------------------------------------------------------------
            | API Card Properties
            |--------------------------------------------------------------------------
            */

            $table->unsignedTinyInteger('api_retreat')->nullable();
            $table->string('api_regulation_mark')->nullable();
            $table->json('api_variants')->nullable();
            $table->json('api_variants_detailed')->nullable();

            /*
            |--------------------------------------------------------------------------
            | API Card Abilities and Combat Information
            |--------------------------------------------------------------------------
            */

            $table->json('api_abilities')->nullable();
            $table->json('api_attacks')->nullable();
            $table->json('api_weaknesses')->nullable();
            $table->json('api_resistances')->nullable();

            /*
            |--------------------------------------------------------------------------
            | API Legal Information
            |--------------------------------------------------------------------------
            */

            $table->json('api_legal')->nullable();

            /*
            |--------------------------------------------------------------------------
            | API Synchronization
            |--------------------------------------------------------------------------
            */

            $table->timestamp('api_updated_at')->nullable();
            $table->json('api_data')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Custom Information
            |--------------------------------------------------------------------------
            */

            $table->string('name')->nullable();

            $table->foreignId('image_asset_id')
                ->nullable()
                ->constrained('assets')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index(['set_id', 'api_local_id']);
            $table->index('api_name');
            $table->index('api_category');
            $table->index('api_rarity');
            $table->index('api_illustrator');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemon_tcg_cards');
    }
};