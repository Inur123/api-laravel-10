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
        Schema::create('podcast_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User ID
            $table->foreignId('podcast_id')->constrained()->onDelete('cascade'); // Podcast ID
            $table->boolean('is_completed')->default(false); // Track if the podcast has been completed
            $table->integer('progress')->default(0); // Track progress as a percentage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('podcast_users');
    }
};
