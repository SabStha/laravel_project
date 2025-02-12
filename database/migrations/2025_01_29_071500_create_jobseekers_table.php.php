<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('jobseekers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Links to users
            $table->boolean('evaluation')->default(false); // Indicates if evaluated
            $table->timestamps();
            $table->softDeletes(); // Soft delete support
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobseekers');
    }
};
