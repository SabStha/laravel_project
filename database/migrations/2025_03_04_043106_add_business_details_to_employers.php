<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('employers', function (Blueprint $table) {
            if (!Schema::hasColumn('employers', 'business_type')) {
                $table->enum('business_type', ['法人', '個人事業主'])->after('company_name');
            }
            if (!Schema::hasColumn('employers', 'business_number')) {
                $table->string('business_number')->nullable()->after('business_type');
            }
            if (!Schema::hasColumn('employers', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('business_number');
            }
            if (!Schema::hasColumn('employers', 'prefecture')) {
                $table->string('prefecture')->nullable()->after('postal_code');
            }
            if (!Schema::hasColumn('employers', 'municipality')) {
                $table->string('municipality')->nullable()->after('prefecture');
            }
            if (!Schema::hasColumn('employers', 'address')) {
                $table->string('address')->nullable()->after('municipality');
            }
            if (!Schema::hasColumn('employers', 'building_name')) {
                $table->string('building_name')->nullable()->after('address');
            }
            if (!Schema::hasColumn('employers', 'contact_phone')) {
                $table->string('contact_phone')->nullable()->after('building_name');
            }
            if (!Schema::hasColumn('employers', 'business_category_id')) {
                $table->unsignedBigInteger('business_category_id')->nullable()->after('contact_phone');
                $table->foreign('business_category_id')->references('id')->on('business_categories')->onDelete('set null');
            }
            if (!Schema::hasColumn('employers', 'desired_work_id')) {
                $table->unsignedBigInteger('desired_work_id')->nullable()->after('business_category_id');
                $table->foreign('desired_work_id')->references('id')->on('tasks')->onDelete('set null');
            }
            if (!Schema::hasColumn('employers', 'challenges')) {
                $table->text('challenges')->nullable()->after('desired_work_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropForeign(['business_category_id']);
            $table->dropForeign(['desired_work_id']);
            $table->dropColumn([
                'business_type', 'business_number', 'postal_code', 'prefecture', 'municipality',
                'address', 'building_name', 'contact_phone', 'business_category_id',
                'desired_work_id', 'challenges'
            ]);
        });
    }
};
