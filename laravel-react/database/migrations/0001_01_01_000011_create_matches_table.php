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

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('Company_ID')->references('Company_ID')->on('companies')->onDelete('cascade');
            $table->foreign('Student_ID')->references('Student_ID')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
