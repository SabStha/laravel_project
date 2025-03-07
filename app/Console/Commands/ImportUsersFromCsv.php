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

            // Đọc file CSV
            $csv = Reader::createFromPath($csvPath, 'r');
            $csv->setHeaderOffset(0);
            
            DB::beginTransaction();
            
            foreach ($csv as $record) {
                // Debug thông tin
                $this->info('Processing record: ' . print_r($record, true));
                
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

                // Tạo hoặc cập nhật jobseeker profile nếu là jobseeker
                if ($user->user_type === 'jobseeker') {
                    Jobseeker::updateOrCreate(
                        ['user_id' => $user->id],
                        ['survey_completed' => false]
                    );
                }

                $this->info("Processed user: {$user->email} with password: {$password}");
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