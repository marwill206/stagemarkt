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
        Schema::create('matches', function (Blueprint $table) {
            $table->id('match_ID');
            $table->unsignedBigInteger('Company_ID');
            $table->unsignedBigInteger('Student_ID');

             $table->foreign('Company_ID')->references('id')->on('companys')->onDelete('set null');
              $table->foreign('Student_ID')->references('id')->on('students')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_school');
    }
};
