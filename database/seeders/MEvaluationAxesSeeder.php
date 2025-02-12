<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MEvaluationAxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $evaluationAxes = [
            [
                'id' => 10,
                'name' => '素直さ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 20,
                'name' => '稼ぎたい',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 30,
                'name' => '日本語',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 40,
                'name' => '几帳面',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 50,
                'name' => '飲食の経験',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 60,
                'name' => '長期的な意識',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_evaluation_axes')->insert($evaluationAxes);
    }
}
