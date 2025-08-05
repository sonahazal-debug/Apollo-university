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
        Schema::create('exam_pattern_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_pattern_id');
            $table->integer('course_id');
            $table->integer('category_id');
            $table->string('from');
            $table->string('to');
            $table->string('correct_mark');
            $table->string('negative_mark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_pattern_categories');
    }
};
