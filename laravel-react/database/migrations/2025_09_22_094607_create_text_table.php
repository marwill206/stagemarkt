<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('text', function (Blueprint $table) {
            $table->id('Text_ID');         // Primary key
            $table->string('Text_Name');   // Name/title of the text
            $table->text('text');          // The actual text content
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('text');
    }
};
