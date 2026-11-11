<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pokemon_tcg_sets', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | TCGdex
            |--------------------------------------------------------------------------
            */

            $table->string('external_id', 100)->unique();

            $table->foreignId('series_id')
                ->constrained('pokemon_tcg_series');

            $table->string('api_name')->nullable();
            $table->text('api_logo_url')->nullable();
            $table->text('api_symbol_url')->nullable();
            $table->date('api_release_date')->nullable();
            $table->unsignedInteger('api_card_count_total')->nullable();
            $table->unsignedInteger('api_card_count_official')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Custom
            |--------------------------------------------------------------------------
            */

            $table->string('name')->nullable();

            $table->foreignId('logo_asset_id')
                ->nullable()
                ->constrained('assets')
                ->nullOnDelete();

            $table->foreignId('symbol_asset_id')
                ->nullable()
                ->constrained('assets')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemon_tcg_sets');
    }
};