<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('jobseekers', function (Blueprint $table) {
            $table->dropColumn('wage'); // Drop ENUM column first
        });

        Schema::table('jobseekers', function (Blueprint $table) {
            $table->integer('wage')->nullable()->after('parttimejob'); // Add INTEGER column
        });
    }

    public function down()
    {
        Schema::table('jobseekers', function (Blueprint $table) {
            $table->dropColumn('wage'); // Drop INTEGER column first
        });

        Schema::table('jobseekers', function (Blueprint $table) {
            $table->enum('wage', ['800', '900', '1000', '1100', '1200', '1300', '1400', '1500'])->nullable();
        });
    }
};
