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
        Schema::create('m_status', function (Blueprint $table) {
            $table->id(); // 主キー（自動増加）
            $table->string('status_code', 50)->unique(); // ステータスコード（例: APPLIED）
            $table->string('status_name', 255); // ステータス名（例: 応募済み）
            $table->text('description')->nullable(); // ステータスの説明（任意）
            $table->timestamps(); // 作成日時・更新日時
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_status');
    }
};
