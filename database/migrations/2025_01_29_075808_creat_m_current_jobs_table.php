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
        if (!Schema::hasTable('issues')) { // Kiểm tra nếu bảng chưa tồn tại
            Schema::create('issues', function (Blueprint $table) {
                $table->id();
                $table->string('code', 255)->unique(); // Thay text thành string(255)
                $table->text('issue_name');
                $table->integer('display_order')->default(10);
                $table->timestamps();
            });
        }
    }
    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_jobs');
    }
};