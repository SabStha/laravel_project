<?php
namespace App\Services;

class PasswordGeneratorService
{
    public function generate()
    {
        $length = config('passwords.min_length', 8);
        $lowercase = 'abcdefghijkmnopqrstuvwxyz'; // lを除外
        
        // 大文字（見分けやすい）
        $uppercase = 'ABCDEFGHJKLMNPQRSTUVWXYZ'; // IOを除外
        
        // 数字（見分けやすい）
        $numbers = '23456789'; // 01を除外
        
        // 記号（見分けやすい）
        $special = '@#$%^&*_-+=!?'; // 紛らわしい記号を除外
        
        $chars = '';
        if (config('passwords.lowercase', true)) $chars .= $lowercase;
        if (config('passwords.uppercase', true)) $chars .= $uppercase;
        if (config('passwords.numbers', true)) $chars .= $numbers;
        if (config('passwords.special_characters', true)) $chars .= $special;
        
        // 各文字タイプから少なくとも1文字を含めることを保証する
        $password = '';
        
        if (config('passwords.lowercase', true) && strlen($password) < $length) {
            $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        }
        
        if (config('passwords.uppercase', true) && strlen($password) < $length) {
            $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        }
        
        if (config('passwords.numbers', true) && strlen($password) < $length) {
            $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        }
        
        if (config('passwords.special_characters', true) && strlen($password) < $length) {
            $password .= $special[random_int(0, strlen($special) - 1)];
        }
        
        // 残りのパスワードを埋める
        while (strlen($password) < $length) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        
        // パスワードをシャッフルする
        return str_shuffle($password);
    }
}