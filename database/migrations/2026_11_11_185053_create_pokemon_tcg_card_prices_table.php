<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pokemon_tcg_card_prices', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            $table->foreignId('card_id')
                ->constrained('pokemon_tcg_cards')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Card Variant
            |--------------------------------------------------------------------------
            */

            $table->string('variant_key')->default('card');
            $table->string('variant_type')->nullable();
            $table->string('variant_subtype')->nullable();
            $table->json('variant_data')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Price Provider
            |--------------------------------------------------------------------------
            */

            $table->string('source', 32);
            $table->string('currency', 3)->nullable();
            $table->string('external_product_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Price Information
            |--------------------------------------------------------------------------
            */

            $table->json('price_data')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Synchronization
            |--------------------------------------------------------------------------
            */

            $table->timestamp('source_updated_at')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->unique(
                ['card_id', 'variant_key', 'source'],
                'pokemon_tcg_card_prices_card_variant_source_unique'
            );

            $table->index(['source', 'source_updated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemon_tcg_card_prices');
    }
};