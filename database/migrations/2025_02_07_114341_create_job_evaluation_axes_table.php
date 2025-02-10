<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('t_job_evaluation_axes', function (Blueprint $table) {
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade'); // FK to jobs
            $table->foreignId('evaluation_axis_id')->constrained('m_evaluation_axes')->onDelete('cascade'); // FK to evaluation axes
            $table->timestamps(); // created_at and updated_at

            $table->primary(['job_id', 'evaluation_axis_id']); // Composite primary key
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_job_evaluation_axes');
    }
};
