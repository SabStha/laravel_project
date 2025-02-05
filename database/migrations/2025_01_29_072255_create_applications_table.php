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
        Schema::create('applications', function (Blueprint $table) {
            $table->id(); // 応募ID（主キー）
            $table->unsignedBigInteger('job_id'); // 求人ID（jobsテーブルの外部キー）
            $table->unsignedBigInteger('jobseeker_id'); // 求職者ID（jobseekersテーブルの外部キー）
            $table->string('status_code', 50); // ステータスコード（m_status.status_code を参照）
            $table->text('comment')->nullable(); // 応募理由（任意）
            $table->timestamp('applied_at')->useCurrent(); // 応募日
            $table->timestamp('interview_at')->nullable(); // 面接日（任意）
            $table->timestamps(); // 作成日時・更新日時
            $table->softDeletes(); // 削除日時

            // 外部キー制約
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->foreign('jobseeker_id')->references('id')->on('jobseekers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
