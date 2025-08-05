<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamManagementsTable extends Migration
{
    public function up()
    {
        Schema::create('exam_managements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('test_type')->nullable();
            $table->string('exam_name')->nullable();
            $table->string('exam_mode')->nullable();
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->nullable();
            $table->string('time_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
