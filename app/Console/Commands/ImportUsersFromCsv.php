<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Jobseeker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ImportUsersFromCsv extends Command
{
    protected $signature = 'users:import {csv_file : Path to the CSV file}';
    protected $description = 'Import users from CSV file';

    public function handle()
    {
        $this->info('Starting import process...');
        
        try {
            $csvPath = $this->argument('csv_file');
            
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
            
            foreach ($csv as $record) {
                // Debug thông tin
                $this->info('Processing record: ' . print_r($record, true));
                
                // Xử lý ngày tháng
                $birthday = null;
                if (!empty($record['birthday'])) {
                    try {
                        $birthday = Carbon::parse(trim($record['birthday']))->format('Y-m-d');
                    } catch (\Exception $e) {
                        $this->warn("Invalid birthday format for record: " . $record['id']);
                    }
                }

                $expectedToGraduate = null;
                if (!empty($record['expected to graduate'])) {
                    try {
                        $expectedToGraduate = Carbon::parse(trim($record['expected to graduate']))->format('Y-m-d');
                    } catch (\Exception $e) {
                        $this->warn("Invalid expected graduation date format for record: " . $record['id']);
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
            
            DB::commit();
            $this->info('Import completed successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Import failed: " . $e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }
}