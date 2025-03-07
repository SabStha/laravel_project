<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Jobseeker;
use App\Models\JobseekerSurvey;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ImportUsersFromCsv extends Command
{
    protected $signature = 'data:import {csv_file} {--type=users : Type of data to import (users, jobseekers, surveys)}';
    protected $description = 'Import users from CSV file';

    public function handle()
    {
        $this->info('Starting import process...');
        
        try {
            $csvPath = $this->argument('csv_file');
            $type = $this->option('type');
            
            if (!file_exists($csvPath)) {
                throw new \Exception('CSV file not found');
            }

            // Đọc file CSV và xử lý header trùng lặp
            $csv = Reader::createFromPath($csvPath, 'r');
            
            // Đọc header và xử lý trùng lặp
            $headers = $csv->fetchOne();
            $uniqueHeaders = [];
            foreach ($headers as $index => $header) {
                if (isset($uniqueHeaders[$header])) {
                    $uniqueHeaders[$header . '_' . $index] = $index;
                } else {
                    $uniqueHeaders[$header] = $index;
                }
            }
            
            // Đặt header mới
            $csv->setHeaderOffset(0);
            
            DB::beginTransaction();
            
            // Xác định loại import dựa trên tham số --type
            if ($type === 'users') {
                $this->importUsers($csv);
            } elseif ($type === 'jobseekers') {
                $this->importJobseekers($csv);
            } elseif ($type === 'surveys') {
                $this->importSurveys($csv);
            } else {
                throw new \Exception("Unknown import type: {$type}");
            }
            
            DB::commit();
            $this->info('Import completed successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Import failed: " . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }

    protected function importUsers($csv)
    {
        $this->info('Importing users...');
        
        foreach ($csv as $record) {
            // Debug thông tin
            $this->info('Processing user record: ' . print_r($record, true));
            
            // Tạo mật khẩu ngẫu nhiên nếu không có
            $password = $record['password'] ?: Str::random(10);
            
            // Tạo hoặc cập nhật user
            $user = User::updateOrCreate(
                ['email' => trim($record['email'])], // Điều kiện kiểm tra trùng lặp
                [
                    'name' => trim($record['name']),
                    'password' => Hash::make($password),
                    'user_type' => $record['user_type'] ?: 'jobseeker',
                    'email_verified_at' => $record['email_verified_at'] ?: null,
                    'remember_token' => $record['remember_token'] ?: null,
                    'created_at' => $record['created_at'] ?: now(),
                    'updated_at' => $record['updated_at'] ?: now()
                ]
            );

            $this->info("Processed user: {$user->email} with password: {$password}");
        }
    }

    protected function importJobseekers($csv)
    {
        $this->info('Importing jobseekers...');
        
        foreach ($csv as $record) {
            // Debug thông tin
            $this->info('Processing jobseeker record: ' . print_r($record, true));
            
            // Xử lý ngày tháng
            $birthday = null;
            if (!empty($record['birthday'])) {
                try {
                    $birthday = Carbon::parse(trim($record['birthday']))->format('Y-m-d');
                } catch (\Exception $e) {
                    $this->warn("Invalid birthday format for record: " . ($record['id'] ?? 'unknown'));
                }
            }

            $expectedToGraduate = null;
            if (!empty($record['expected to graduate'])) {
                try {
                    $expectedToGraduate = Carbon::parse(trim($record['expected to graduate']))->format('Y-m-d');
                } catch (\Exception $e) {
                    $this->warn("Invalid expected graduation date format for record: " . ($record['id'] ?? 'unknown'));
                }
            }

            // Tạo jobseeker profile với đầy đủ các trường
            $jobseeker = Jobseeker::create([
                'user_id' => $record['user_id'] ?: null,
                'birthday' => $birthday,
                'gender' => trim($record['gender'] ?? ''),
                'citizenship' => trim($record['citizenship'] ?? ''),
                'school' => trim($record['school'] ?? ''),
                'jlpt' => trim($record['jlpt'] ?? ''),
                'expected_to_graduate' => $expectedToGraduate,
                'parttimejob' => trim($record['parttimejob'] ?? ''),
                'wage' => trim($record['wage'] ?? ''),
                'time' => trim($record['time'] ?? ''),
                'evaluation' => trim($record['evaluation'] ?? ''),
                'survey_completed' => true,
                'created_at' => !empty($record['created_at']) ? Carbon::parse(trim($record['created_at'])) : now(),
                'updated_at' => !empty($record['updated_at']) ? Carbon::parse(trim($record['updated_at'])) : now(),
                'deleted_at' => !empty($record['deleted_at']) ? Carbon::parse(trim($record['deleted_at'])) : null
            ]);

            $this->info("Created jobseeker record with ID: {$jobseeker->id}");
        }
    }

    protected function importSurveys($csv)
    {
        $this->info('Importing jobseeker surveys...');
        
        foreach ($csv as $record) {
            // Debug thông tin
            $this->info('Processing survey record: ' . print_r($record, true));
            
            // Kiểm tra jobseeker_id có tồn tại không
            $jobseekerId = $record['jobseeker_id'] ?? null;
            if (!$jobseekerId) {
                $this->warn("Missing jobseeker_id for record, skipping");
                continue;
            }
            
            // Kiểm tra jobseeker có tồn tại không
            $jobseekerExists = Jobseeker::where('id', $jobseekerId)->exists();
            if (!$jobseekerExists) {
                $this->warn("Jobseeker with ID {$jobseekerId} does not exist, skipping");
                continue;
            }

            // Xử lý ngày tháng
            $createdAt = null;
            if (!empty($record['created_at'])) {
                try {
                    $createdAt = Carbon::parse(trim($record['created_at']));
                } catch (\Exception $e) {
                    $this->warn("Invalid created_at format for record ID: " . ($record['id'] ?? 'unknown'));
                }
            }

            $updatedAt = null;
            if (!empty($record['updated_at'])) {
                try {
                    $updatedAt = Carbon::parse(trim($record['updated_at']));
                } catch (\Exception $e) {
                    $this->warn("Invalid updated_at format for record ID: " . ($record['id'] ?? 'unknown'));
                }
            }

            // Tạo survey record
            $survey = JobseekerSurvey::create([
                'jobseeker_id' => $jobseekerId,
                'survey_id' => $record['survey_id'] ?? null,
                'selected_option' => trim($record['selected_option'] ?? ''),
                'score' => $record['score'] ?? 0,
                'created_at' => $createdAt ?: now(),
                'updated_at' => $updatedAt ?: now()
            ]);

            $this->info("Created jobseeker survey record with ID: {$survey->id}");
        }
    }
}