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
        Schema::create('job_items', function (Blueprint $table) {
            $table->id(); // アイテムID（主キー）
            $table->unsignedBigInteger('category_id'); // カテゴリID（外部キー）
            $table->text('code'); // 英字と数字のコード
            $table->text('item_name'); // アイテム名称
            $table->integer('display_order')->default(0); // 表示順（小さい方が先に表示される）
            $table->timestamps(); // 作成日時・更新日時

            // 外部キー制約
            $table->foreign('category_id')->references('id')->on('job_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_items');
    }
};
