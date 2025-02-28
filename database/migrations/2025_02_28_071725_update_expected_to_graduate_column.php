<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('jobseekers', function (Blueprint $table) {
            // Change expected_to_graduate to store only YYYY-MM as a string
            $table->string('expected_to_graduate')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('jobseekers', function (Blueprint $table) {
            // Rollback to previous format (date format)
            $table->date('expected_to_graduate')->default('2025-01-01')->change();
        });
    }
};
