<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionManagementsTable extends Migration
{
    public function up()
    {
        Schema::create('question_managements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('question')->nullable();
            $table->string('question_type')->nullable();
            $table->longText('option_1')->nullable();
            $table->longText('option_2')->nullable();
            $table->longText('option_3')->nullable();
            $table->longText('option_4')->nullable();
            $table->string('option_1_image')->nullable();
            $table->string('option_2_image')->nullable();
            $table->string('answer')->nullable();
            $table->string('terms')->nullable();
            $table->string('difficulty_level')->nullable();
            $table->longText('explaination')->nullable();
            $table->longText('explaination_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
