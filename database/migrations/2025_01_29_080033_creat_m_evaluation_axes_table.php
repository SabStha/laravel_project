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
        Schema::create('m_evaluation_axes', function (Blueprint $table) {
            $table->id(); // 主キー（自動採番）
            $table->string('name', 100); // 評価軸の名称（日本語）
            $table->timestamp('created_at')->useCurrent(); // レコード作成日時（デフォルトで現在時刻）
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // レコード更新日時（更新時に自動更新）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_evaluation_axes');
    }
};
