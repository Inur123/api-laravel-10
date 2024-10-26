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
        Schema::table('girly_pedia_user', function (Blueprint $table) {
            $table->unsignedTinyInteger('progress')->default(0)->after('is_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('girly_pedia_user', function (Blueprint $table) {
            $table->dropColumn('progress');
        });
    }
};
