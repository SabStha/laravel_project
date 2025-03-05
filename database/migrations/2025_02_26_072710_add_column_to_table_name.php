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
        Schema::table('jobs', function (Blueprint $table) {
            if (!Schema::hasColumn('jobs', 'image')) {
                $table->string('image');
            }
            if (!Schema::hasColumn('jobs', 'working_days')) {
                $table->json('working_days');
            }
            if (!Schema::hasColumn('jobs', 'working_hours')) {
                $table->string('working_hours');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn(['image', 'working_days', 'working_hours']);
        });
    }
};
