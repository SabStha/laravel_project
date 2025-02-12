<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobseeker_id')->constrained('jobseekers')->onDelete('cascade'); // Links to jobseekers
            $table->foreignId('operator_id')->constrained('users')->onDelete('cascade'); // Links to operators
            $table->float('rating')->default(0); // Default rating
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};
