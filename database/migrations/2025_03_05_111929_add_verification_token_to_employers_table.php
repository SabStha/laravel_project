<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('employers', function (Blueprint $table) {
        $table->string('verification_token')->nullable()->unique()->after('user_id');
    });
}

public function down()
{
    Schema::table('employers', function (Blueprint $table) {
        if (Schema::hasColumn('employers', 'verification_token')) {
            $table->dropColumn('verification_token');
        }
    });
}

};
