<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pokemon_tcg_series', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | TCGdex
            |--------------------------------------------------------------------------
            */

            $table->string('external_id', 100)->unique();
            $table->string('api_name')->nullable();
            $table->text('api_logo_url')->nullable();

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

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pokemon_tcg_series');
    }
};