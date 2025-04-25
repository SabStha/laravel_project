<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jobseeker;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class JobseekerSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $citizenshipOptions = [
            'イラン', 'インド', 'インドネシア', 'ウクライナ', 'ウズベキスタン', 'エジプト', 
            'キルギス', 'シンガポール', 'ネパール', 'スリランカ', 'バングラデシュ', 
            'パキスタン', 'ベトナム', 'マレーシア', 'ミャンマー', 'モンゴル', 'ロシア', 
            '中国', '日本', '韓国', 'その他'
        ];

        $schoolOptions = [
            '愛和外語学院', '九州ビジネス専門学校', '国際アニメーション専門学校', 
            '愛和システムエンジニア専門学校', 'グローバルクリエイター専門学校'
        ];

        $jlptLevels = ['N1', 'N2', 'N3', 'N4', 'N5', 'なし'];
        $wageOptions = ['800', '900', '1000', '1100', '1200', '1300', '1400', '1500'];
        $timeOptions = [1, 2, 3, 4, 5]; // Random time slots

        for ($i = 0; $i < 50; $i++) { // Generate 50 jobseekers
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'user_type' => 'jobseeker',
            ]);

            Jobseeker::create([
                'user_id' => $user->id,
                'evaluation' => $faker->boolean,
                'birthday' => $faker->date(),
                'gender' => $faker->randomElement(['male', 'female', 'other']),
                'citizenship' => $faker->randomElement($citizenshipOptions),
                'custom_citizenship' => $faker->country, // User-entered custom citizenship
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'school' => $faker->randomElement($schoolOptions),
                'image' => 'default.jpg', // Placeholder image
                'residentcard' => $faker->uuid,
                'jlpt' => $faker->randomElement($jlptLevels),
                'expected_to_graduate' => $faker->date('Y-m-d', '2026-01-01'), // Future date
                'parttimejob' => $faker->boolean,
                'wage' => $faker->randomElement($wageOptions),
                'time' => $faker->randomElement($timeOptions),
                'survey_completed' => $faker->boolean,
                'total_score' => $faker->numberBetween(0, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
