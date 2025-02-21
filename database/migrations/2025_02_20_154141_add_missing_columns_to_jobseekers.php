<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('jobseekers', function (Blueprint $table) {
            $table->date('birthday')->nullable()->default(null);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->enum('citizenship', [
                'イラン', 'インド', 'インドネシア', 'ウクライナ', 'ウズベキスタン', 'エジプト', 
                'キルギス', 'シンガポール', 'ネパール', 'スリランカ', 'バングラデシュ', 
                'パキスタン', 'ベトナム', 'マレーシア', 'ミャンマー', 'モンゴル', 'ロシア', 
                '中国', '日本', '韓国', 'その他'
            ])->nullable();
            
            $table->string('custom_citizenship')->nullable(); // Store user-entered custom country
            
            $table->string('phone')->nullable();
            $table->string('address', 255)->nullable();
            $table->enum('school', [
                '愛和外語学院', 
                '九州ビジネス専門学校', 
                '国際アニメーション専門学校', 
                '愛和システムエンジニア専門学校', 
                'グローバルクリエイター専門学校'
            ])->nullable();
            $table->string('image')->nullable();
            $table->string('residentcard')->nullable(); // URL of resident card image
            $table->enum('jlpt', ['N1', 'N2', 'N3', 'N4', 'N5', 'なし'])->nullable();
            $table->date('expected_to_graduate')->default('2025-01-01'); // Ensure a valid default date
            $table->boolean('parttimejob')->default(false);
            $table->enum('wage', ['800', '900', '1000', '1100', '1200', '1300', '1400', '1500'])->nullable();

            $table->integer('time')->nullable();
        });
    }

    public function down()
    {
        Schema::table('jobseekers', function (Blueprint $table) {
            $table->dropColumn([
                'birthday', 
                'gender', 
                'citizenship', 
                'custom_citizenship',
                'phone', 
                'address', 
                'school', 
                'image',
                'residentcard', 
                'jlpt', 
                'expected_to_graduate', 
                'parttimejob', 
                'wage', 
                'time'
            ]);
        });
    }
};
