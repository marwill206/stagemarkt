<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('image', function (Blueprint $table) {
            $table->id('img_id');          // Primary key
            $table->string('img_name');    // Name of the image
            $table->string('img_url');     // File path or URL
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image');
    }
};
