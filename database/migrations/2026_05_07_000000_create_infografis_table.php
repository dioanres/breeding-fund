<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infografis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file');
            $table->enum('type', ['image', 'pdf']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infografis');
    }
};
