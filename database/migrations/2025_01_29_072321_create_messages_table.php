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
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // メッセージID（主キー）
            $table->unsignedBigInteger('sender_id'); // 送信者ID（usersテーブルの外部キー）
            $table->unsignedBigInteger('receiver_id'); // 受信者ID（usersテーブルの外部キー）
            $table->text('message'); // メッセージ内容
            $table->timestamp('sent_at')->useCurrent(); // 送信日時
            $table->timestamps(); // 作成日時・更新日時
            $table->softDeletes(); // 削除日時

            // 外部キー制約
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
