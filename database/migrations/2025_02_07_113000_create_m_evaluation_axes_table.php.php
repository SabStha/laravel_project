<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('m_evaluation_axes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique();
            $table->string('name', 100);
            $table->timestamps();
        });

        // Insert initial evaluation axes (SND, RKA, etc.)
        DB::table('m_evaluation_axes')->insert([
            ['code' => 'SND', 'name' => '素直さ (Honesty)', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'RKA', 'name' => '稼ぎたい (Desire to Earn)', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'JPN', 'name' => '日本語 (Japanese Proficiency)', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'KIC', 'name' => '几帳面 (Meticulousness)', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'INS', 'name' => '飲食の経験 (Food Industry Experience)', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'LNG', 'name' => '長期的な意識 (Long-term Commitment)', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('m_evaluation_axes');
    }
};
