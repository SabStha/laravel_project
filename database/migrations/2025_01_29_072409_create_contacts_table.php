<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); // 問い合わせID（主キー）
            $table->unsignedBigInteger('user_id'); // ユーザーID（usersテーブルの外部キー）
            $table->text('message'); // 問い合わせ内容
            $table->enum('status', ['pending', 'resolved'])->default('pending'); // 問い合わせのステータス（未解決、解決済み）
            $table->timestamps(); // 作成日時・更新日時
            $table->softDeletes(); // 削除日時

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
