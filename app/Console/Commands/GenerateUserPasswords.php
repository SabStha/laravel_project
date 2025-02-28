<?php
namespace App\Console\Commands;

use App\Models\User;
use App\Services\PasswordGeneratorService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GenerateUserPasswords extends Command
{
    protected $signature = 'users:generate-passwords 
    {--file= : CSVファイルにパスワードをエクスポート} 
    {--force : 確認なしで実行}
    {--send-email : メールを送信する}
    {--batch-email : メールを一括送信する（確認なし）}';

    protected $description = 'すべてのユーザーに新しいパスワードを生成する。メール送信は --send-email オプションが必要です。';

    public function handle()
    {
        $this->displayHeader();

        if ($this->option('send-email')) {
            $this->warn('注意: メール送信モードが有効です');
            
            if ($this->option('batch-email')) {
                $this->warn('注意: 一括メール送信モードが有効です（確認なし）');
            }
            
            if (!$this->option('force') && !$this->confirm('メール送信を含む処理を実行しますか？')) {
                $this->info('操作がキャンセルされました。');
                return;
            }
        } else {
            $this->info('メール送信は無効です。送信するには --send-email オプションを使用してください。');
        }

        try {
            Log::info('パスワード生成処理を開始しました');

            // Lấy tất cả users mà không cần lọc
            $users = User::all();
            if ($users->isEmpty()) {
                $this->warn('データベースにユーザーが見つかりませんでした！');
                return;
            }

            $newPasswords = [];
            $passwordService = new PasswordGeneratorService();
            $totalUsers = $users->count();
            $progressBar = $this->output->createProgressBar($totalUsers);

            foreach ($users as $index => $user) {
                if (!$this->validateUser($user)) {
                    $progressBar->advance();
                    continue;
                }

                $newPassword = $passwordService->generate();
                $user->password = Hash::make($newPassword);
                $user->save();

                $this->sendPasswordEmail($user->email, $newPassword, $user->name ?? 'ユーザー');

                $newPasswords[] = [
                    'email' => $user->email,
                    'password' => $newPassword,
                ];

                $progressBar->advance();
                $this->displayUserProgress($user->email, $index + 1, $totalUsers);
            }

            $progressBar->finish();
            $this->newLine();

            if ($filePath = $this->option('file')) {
                $this->exportPasswords($newPasswords, $filePath);
            }

            Log::info('パスワード生成処理が完了しました');
            $this->displaySuccess(count($newPasswords));
        } catch (\Exception $e) {
            Log::error('パスワード生成または送信中にエラー: ' . $e->getMessage());
            $this->error('エラーが発生しました: ' . $e->getMessage());
        }
    }

    private function displayHeader()
    {
        $this->line('');
        $this->info('===================================');
        $this->info('     パスワード生成ツール v1.0     ');
        $this->info('===================================');
        $this->line('');
    }

    private function displayUserProgress($email, $current, $total)
    {
        $this->output->write("\033[1A");
        $this->info(sprintf("処理中: %s (%d/%d)", $email, $current, $total));
    }

    private function displaySuccess($count)
    {
        $this->newLine();
        $this->line('-------------------------');
        $this->info("✔ 成功: {$count}人のユーザーにパスワードを生成しました！");
        
        if (!$this->option('send-email')) {
            $this->comment("※ メールは送信されていません。送信するには --send-email オプションを使用してください。");
        } else {
            $this->info("✔ メール送信: 完了");
        }
        
        $this->line('-------------------------');
    }

    private function validateUser($user)
    {
        if (empty($user->email)) {
            Log::warning("ユーザーID {$user->id} にメールアドレスがありません");
            $this->warn("スキップ: ユーザーID {$user->id} - メールなし");
            return false;
        }
        return true;
    }

    private function sendPasswordEmail($email, $password, $name)
{
    if (!$this->option('send-email')) {
        $this->line("  - メール送信をスキップ: {$email}");
        return;
    }

    try {
        $loginUrl = config('app.url') . '/login';
        
        // --batch-emailオプションがある場合、または--forceオプションがある場合は確認なしで送信
        if (!$this->option('force') && !$this->option('batch-email')) {
            if (!$this->confirm("  - メールを送信します: {$email}. よろしいですか？")) {
                $this->info("  - メール送信をスキップしました: {$email}");
                return;
            }
        }

        Mail::send('emails.initial-password', [
            'password' => $password,
            'loginUrl' => $loginUrl,
            'email' => $email,
            'name' => $name
        ], function($message) use ($email) {
            $message->to($email);
            $message->subject('初期パスワードのお知らせ');
        });

        $this->info("  - メール送信完了: {$email}");
        Log::info("パスワードメール送信成功", ['email' => $email]);
    } catch (\Exception $e) {
        $this->error("  - メール送信エラー: {$email}");
        Log::error("メール送信エラー", [
            'email' => $email,
            'error' => $e->getMessage()
        ]);
        throw $e;
    }
}

    private function exportPasswords($passwords, $filePath)
    {
        $fullPath = storage_path('app/' . $filePath);
        $file = fopen($fullPath, 'w');
        fputcsv($file, ['メール', 'パスワード']); 

        foreach ($passwords as $password) {
            fputcsv($file, [
                $password['email'],
                $password['password'],
            ]);
        }

        fclose($file);
        $this->info("パスワードを {$fullPath} にエクスポートしました");
    }
}