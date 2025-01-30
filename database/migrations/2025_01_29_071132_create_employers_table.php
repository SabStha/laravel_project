<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('employers', function (Blueprint $table) {
     
        //     if (!Schema::hasColumn('employers', 'id')) {
        //         $table->id(); 
        //     }

        //     if (!Schema::hasColumn('employers', 'user_id')) {
        //         $table->integer('user_id')->unsigned(); 
        //     }
        // });

        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('employers', function (Blueprint $table) {

        //     if (Schema::hasColumn('employers', 'user_id')) {
        //         $table->dropColumn('user_id');
        //     }

        //     if (Schema::hasColumn('employers', 'id')) {
        //         $table->dropColumn('id');
        //     }
        // });

        Schema::dropIfExists('employers');
    }
};