<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('studentskill', function (Blueprint $table) {
            $table->id('studentskill_id');

            // Foreign Keys
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('skill_id');

            $table->string('skill_level');
            $table->timestamps();

            // Fixed foreign key constraints
            $table->foreign('student_id')->references('Student_ID')->on('students')->onDelete('cascade');
            $table->foreign('skill_id')->references('skill_id')->on('skill')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studentskill');
    }
};
