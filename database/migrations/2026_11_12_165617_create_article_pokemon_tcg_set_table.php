<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_pokemon_tcg_set', function (Blueprint $table) {
            $table->foreignId('article_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('pokemon_tcg_set_id')
                ->constrained('pokemon_tcg_sets')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'article_id',
                'pokemon_tcg_set_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_pokemon_tcg_set');
    }
};