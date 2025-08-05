<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeadScriptsTable extends Migration
{
    public function up()
    {
        Schema::create('head_scripts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('script')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
