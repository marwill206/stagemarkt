<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id('company_id'); // PK
            $table->string('company_name');
            $table->string('company_email')->unique();
            $table->string('company_address')->nullable();
            $table->string('kvk')->nullable();
            
            // Foreign Key
            $table->unsignedBigInteger('profession_id');
            $table->foreign('profession_id')->references('id')->on('profession')->onDelete('cascade');
            
            $table->string('field')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
