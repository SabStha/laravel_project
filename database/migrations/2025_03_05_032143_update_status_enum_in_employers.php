<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'registered'])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });
    }
};
