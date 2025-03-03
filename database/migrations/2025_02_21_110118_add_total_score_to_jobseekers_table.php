<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('jobseekers', function (Blueprint $table) {
            $table->integer('total_score')->default(0); // Store total survey score
        });
    }

    public function down()
    {
        Schema::table('jobseekers', function (Blueprint $table) {
            $table->dropColumn('total_score');
        });
    }
};
