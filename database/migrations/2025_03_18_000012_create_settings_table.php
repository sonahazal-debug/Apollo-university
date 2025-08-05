<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('webiste_title')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('map')->nullable();
            $table->longText('address')->nullable();
            $table->string('bread_crumb_image')->nullable();
            $table->longText('footer_content')->nullable();
            $table->string('business_name')->nullable();
            $table->string('footer_logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
