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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // 主キー (求人ID)
            $table->unsignedBigInteger('employer_id'); // 外部キー (企業ID)
            $table->string('title', 255); // 求人タイトル
            $table->text('description'); // 求人詳細
            $table->enum('job_type', ['full', 'part', 'contract']); // 雇用形態
            $table->string('location', 255); // 勤務地
            $table->string('salary', 255)->nullable(); // 給与
            $table->text('required_skills')->nullable(); // 応募資格
            $table->boolean('visa_required')->default(false); // ビザが必要かどうか
            $table->timestamp('posted_at')->useCurrent(); // 求人掲載日
            $table->timestamp('expires_at')->nullable(); // 求人の終了日
            $table->timestamps(); // 作成日時・更新日時
            $table->softDeletes(); // 削除日時

            // 外部キー制約
            $table->foreign('employer_id')->references('id')->on('employers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
