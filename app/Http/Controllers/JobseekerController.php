<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jobseeker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import Log at the top of your controller

class JobseekerController extends Controller
{
    public function showRegistrationForm()
{
    // ENUM-based predefined values
    $genders = ['male' => '男性 (Male)', 'female' => '女性 (Female)', 'other' => '回答しない (Prefer not to say)'];
    $citizenships = ['イラン', 'インド', 'インドネシア', 'ウクライナ', 'ウズベキスタン', 'エジプト', 'キルギス', 'シンガポール', 'ネパール', 'スリランカ', 'バングラデシュ', 'パキスタン', 'ベトナム', 'マレーシア', 'ミャンマー', 'モンゴル', 'ロシア', '中国', '日本', '韓国','その他'=> 'その他 (Other)'];
    $schools = [
        '愛和外語学院' => '愛和外語学院',
        '九州ビジネス専門学校' => '九州ビジネス専門学校',
        '国際アニメーション専門学校' => '国際アニメーション専門学校',
        '愛和システムエンジニア専門学校' => '愛和システムエンジニア専門学校',
        'グローバルクリエイター専門学校' => 'グローバルクリエイター専門学校'
    ];
    $jlptLevels = ['N1' => 'N1', 'N2' => 'N2', 'N3' => 'N3', 'N4' => 'N4', 'N5' => 'N5', 'なし' => 'なし (None)'];
    $wageOptions = ['800', '900', '1000', '1100', '1200', '1300', '1400', '1500'];

    return view('jobseeker_register', compact('genders', 'citizenships', 'schools', 'jlptLevels', 'wageOptions'));
}


    

    public function register(Request $request)
    {
        Log::info('Jobseeker registration started', ['request' => $request->all()]);

        // Validate input data
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'birthday' => 'required|date',
                'gender' => 'required|in:male,female,other',
                'citizenship' => 'required|string',
                'custom_citizenship' => 'nullable|string|max:255',
                'school' => 'required|string|in:愛和外語学院,九州ビジネス専門学校,国際アニメーション専門学校,愛和システムエンジニア専門学校,グローバルクリエイター専門学校',
                'jlpt' => 'required|in:N1,N2,N3,N4,N5,なし',
                'expected_to_graduate' => 'required|date|after_or_equal:today',
                'parttimejob' => 'required|boolean',
                'wage' => 'nullable|in:800,900,1000,1100,1200,1300,1400,1500',
                'time' => $request->parttimejob == '1' ? 'required|integer|min:1|max:28' : 'nullable|integer',
            ]);

            Log::info('Validation successful', ['validated' => $validated]);
            DB::transaction(function () use ($validated) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'user_type' => 'jobseeker',
                ]);

                Log::info('User created', ['user' => $user]);

               // Determine citizenship value before inserting into the database
                $citizenship = ($validated['citizenship'] === 'その他') ? 'その他' : $validated['citizenship']; // Store "その他" in ENUM column
                $customCitizenship = ($validated['citizenship'] === 'その他') ? $validated['custom_citizenship'] : null; // Store actual input

                $jobseeker = $user->jobseeker()->create([
                    'user_id' => $user->id,
                    'birthday' => $validated['birthday'],
                    'gender' => $validated['gender'],
                    'citizenship' => $citizenship, // Always valid ENUM value
                    'custom_citizenship' => $customCitizenship, // Stores user input separately
                    'school' => $validated['school'],
                    'jlpt' => $validated['jlpt'],
                    'expected_to_graduate' => date('Y-m-d', strtotime($validated['expected_to_graduate'])),
                    'parttimejob' => $validated['parttimejob'],
                    'wage' =>  $validated['wage'],
                    'time' => $validated['time'],
                ]);



                Log::info('Jobseeker record created', ['jobseeker' => $jobseeker]);
            });

            return redirect()->route('jobseeker.dashboard')->with('success', 'Registration successful.');
        } catch (\Exception $e) {
            Log::error('Error during jobseeker registration', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Something went wrong. Please check the logs.']);
        }
    }
}