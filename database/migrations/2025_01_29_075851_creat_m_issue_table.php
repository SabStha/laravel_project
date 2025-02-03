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
        Schema::create('issues', function (Blueprint $table) {
            $table->id(); // 主キー（自動増加）
            $table->text('code')->unique(); // 一意な課題コード（例: "I01"）
            $table->text('issue_name'); // 課題感の名前（例: "シフトに穴が多い"）
            $table->integer('display_order')->default(10); // 表示順序（10刻み）
            $table->timestamps(); // 作成日時・更新日時
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
