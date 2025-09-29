<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('students', function (Blueprint $table) {
        $table->id('Student_ID'); // primary key
        $table->string('Student_Name');
        $table->string('Student_Email')->unique();
        $table->string('Address')->nullable();
        $table->integer('age')->nullable();
        $table->enum('gender', ['Male', ' Female',' Other'])->nullable();
        $table->string('foto')->nullable();

        //foreign keys
        $table->unsignedBigInteger('Profession_ID')-> nullable();
        $table->unsignedBigInteger('School_ID')->nullable();
        
        $table->timestamps();


          // FK constraints
            $table->foreign('Profession_ID')->references('id')->on('professions')->onDelete('set null');
            $table->foreign('School_ID')->references('id')->on('schools')->onDelete('set null');
       }) ;

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
