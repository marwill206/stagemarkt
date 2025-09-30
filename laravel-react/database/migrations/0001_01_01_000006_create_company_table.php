<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id('Company_ID'); // PK
            $table->string('Company_Name');
            $table->string('Company_Email')->unique();
            $table->string('Company_Address')->nullable();
            $table->string('KVK')->nullable();
            
            // Foreign Key
            $table->unsignedBigInteger('Profession_ID')->nullable();
            $table->foreign('Profession_ID')->references('Profession_ID')->on('professions')->onDelete('cascade');
            
            $table->string('field')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
