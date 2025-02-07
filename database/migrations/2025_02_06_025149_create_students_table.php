<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nim');
            $table->enum('faculty', ['FIT', 'FIK', 'FIP']);
            $table->enum('major', ['computer science', 'doctorate', 'farming technology']);
            $table->date('registered_date')->nullable();
            $table->date('graduation_date')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::statement("ALTER TABLE students ADD CONSTRAINT check_nim CHECK (nim REGEXP '^[0-9]+$')");
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
