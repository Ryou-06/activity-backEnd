<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laravel_enrollees', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 6)->unique();
            $table->string('name', 100);
            $table->string('course', 20);
            $table->unsignedTinyInteger('year');
            $table->string('block', 5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laravel_enrollees');
    }
};