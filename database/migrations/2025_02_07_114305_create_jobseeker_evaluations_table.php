<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('t_jobseeker_evaluations', function (Blueprint $table) {
            $table->foreignId('jobseeker_id')->constrained('jobseekers')->onDelete('cascade'); // FK to jobseekers
            $table->foreignId('evaluation_axis_id')->constrained('m_evaluation_axes')->onDelete('cascade'); // FK to evaluation axes
            $table->tinyInteger('rating')->unsigned()->checkBetween(1, 5); // Rating (1-5)
            $table->timestamps(); // created_at and updated_at

            $table->primary(['jobseeker_id', 'evaluation_axis_id']); // Composite primary key
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_jobseeker_evaluations');
    }
};
