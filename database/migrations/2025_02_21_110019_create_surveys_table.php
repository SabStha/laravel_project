<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->text('question_text');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->text('explanation_a');
            $table->text('explanation_b');
            $table->text('explanation_c');
            $table->text('explanation_d');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surveys');
    }
};
