<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poll_votes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('poll_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('poll_option_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('voter_hash', 64)->nullable();

            $table->timestamps();

            $table->unique(
                ['poll_id', 'user_id'],
                'poll_votes_user_unique'
            );

            $table->unique(
                ['poll_id', 'voter_hash'],
                'poll_votes_guest_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poll_votes');
    }
};