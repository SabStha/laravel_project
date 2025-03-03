<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('jobseekers', function (Blueprint $table) {
            $table->boolean('survey_completed')->default(false)->after('time'); // Add new column
        });
    }

    public function down()
    {
        Schema::table('jobseekers', function (Blueprint $table) {
            $table->dropColumn('survey_completed');
        });
    }
};
