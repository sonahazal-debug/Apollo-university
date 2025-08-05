<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamPatternsTable extends Migration
{
    public function up()
    {
        Schema::create('exam_patterns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number_of_questions')->nullable();
            $table->string('correct_mark')->nullable();
            $table->string('negative_mark')->nullable();
            $table->string('max_attemt_q')->nullable();
            $table->string('is_compulsory')->nullable();
            $table->string('status')->nullable();
            $table->string('total_marks')->nullable();
            $table->string('total_questions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
