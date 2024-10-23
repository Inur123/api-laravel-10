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
        // Migration Update
        Schema::create('menstrual_cycles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menghubungkan dengan tabel users
            $table->date('last_period_start')->comment('Tanggal mulai periode terakhir'); // Tanggal periode terakhir
            $table->date('last_period_finish')->nullable()->comment('Tanggal selesai periode terakhir'); // Tanggal selesai periode terakhir (nullable)
            $table->boolean('is_completed')->default(false)->comment('Status apakah siklus sudah selesai'); // Status siklus
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menstrual_cycles');
    }
};
