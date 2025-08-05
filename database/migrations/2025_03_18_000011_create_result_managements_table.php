<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultManagementsTable extends Migration
{
    public function up()
    {
        Schema::create('result_managements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('total_questions')->nullable();
            $table->string('total_attempted')->nullable();
            $table->string('total_correct')->nullable();
            $table->string('total_wrong')->nullable();
            $table->string('score')->nullable();
            $table->string('rank')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
