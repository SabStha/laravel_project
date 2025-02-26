<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Jobseeker;
use App\Models\Survey;
use App\Models\JobseekerSurvey;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;

class ImportUsersJobseekers extends Command
{
    protected $signature = 'import:users-jobseekers {file}';
    protected $description = 'Import users, jobseekers, and their survey responses from a CSV file';

    public function handle()
    {
        $filePath = storage_path('app/' . $this->argument('file'));

        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        $totalImported = 0;
        foreach ($records as $record) {
            try {
                // Create or find user
                $user = User::firstOrCreate([
                    'email' => trim($record['email'])
                ], [
                    'name' => trim($record['name']),
                    'password' => Hash::make('password123'),
                    'user_type' => 'jobseeker',
                    'email_verified_at' => null
                ]);

                // Create or find jobseeker
                $jobseeker = Jobseeker::firstOrCreate([
                    'user_id' => $user->id
                ], [
                    'birthday' => $this->convertDate($record['birthday']),
                    'gender' => $this->normalizeGender($record['gender']),
                    'citizenship' => trim($record['citizenship']),
                    'school' => trim($record['school']),
                    'jlpt' => trim($record['jlpt']),
                    'expected_to_graduate' => $this->convertDate($record['expected_to_graduate']),
                    'parttimejob' => filter_var($record['parttimejob'], FILTER_VALIDATE_BOOLEAN),
                    'wage' => preg_replace('/[^0-9]/', '', $record['wage']),
                    'time' => preg_replace('/[^0-9]/', '', $record['time']),
                ]);

                // Import survey responses
                $this->importSurveyResponses($jobseeker->id, $record);

                $totalImported++;
            } catch (\Exception $e) {
                Log::error("Error importing record: " . json_encode($record) . " | Error: " . $e->getMessage());
            }
        }

        $this->info("$totalImported users, jobseekers, and their survey responses imported successfully!");
    }

    // Convert date format to YYYY-MM-DD
    private function convertDate($date)
    {
        if (empty($date)) return null;
        $timestamp = strtotime($date);
        return $timestamp ? date('Y-m-d', $timestamp) : null;
    }

    // Normalize gender values
    private function normalizeGender($gender)
    {
        $genderMap = ['男性' => 'male', '女性' => 'female', 'その他' => 'other'];
        return $genderMap[$gender] ?? null;
    }

    // Import survey responses into jobseeker_survey table
    private function importSurveyResponses($jobseeker_id, $record)
    {
        // Map questions to survey IDs
        $surveyQuestions = [
            "① 街で偶然、以前アルバイトでお世話になった店のオーナー に会いました。あなたはどうしますか？  " => 1,
            "② 静かな図書館で勉強していたら、隣の人が電話を始めました。あなたはどうしますか？ " => 2,
            "③ 友達と遊ぶ約束をしていた日に、急に用事ができてしまいました。あなたはどうしますか？ " => 3,
            "④ コンビニでお弁当を買ったら、お箸が入っていませんでした。あなたはどうしますか？ " => 4,
            "⑤  電車の中で、気分が悪くなっている人がいます。あなたはどうしますか？ " => 5,
            "⑥  旅行先で、道に迷ってしまいました。あなたはどうしますか？ " => 6,
            "⑦ 友達の誕生日プレゼントを選ぶことになりました。あなたはどうしますか？   " => 7,
            "⑧ 先輩がスピーチをしています。あなたはどうしますか？  " => 8,
            "⑨ プレゼンテーションで、緊張して言葉が出てこなくなりました。あなたはどうしますか？ " => 9,
            "⑩ 宝くじで10万円が当たりました。あなたはどうしますか？  " => 10
        ];

        foreach ($surveyQuestions as $questionText => $surveyId) {
            if (!isset($record[$questionText])) continue;

            $answer = trim($record[$questionText]);
            $score = $this->calculateScore($answer);

            JobseekerSurvey::updateOrCreate([
                'jobseeker_id' => $jobseeker_id,
                'survey_id' => $surveyId,
            ], [
                'selected_option' => $answer,
                'score' => $score
            ]);
        }
    }

    // Convert survey answer into a score
    private function calculateScore($answer)
    {
        $scores = [
            'a.' => 5,
            'b.' => 3,
            'c.' => 2,
            'd.' => 1
        ];
        return $scores[substr($answer, 0, 2)] ?? 0; // Extract first two characters ('a.', 'b.', etc.)
    }
}
