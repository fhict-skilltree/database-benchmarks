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
        Schema::create('skilltrees', function ($collection) {
//            $table->id();
//            $table->string('title');
//            $table->timestamps();
        });

        Schema::create('skills', function ($collection) {
            $collection->index('ancestors');

//            $table->id();
//            $table->string('title');
//            $table->text('content');
//            $table->unsignedBigInteger('skilltree_id')->nullable();
//            $table->foreign('skilltree_id')->references('id')->on('skilltrees');
//            $table->unsignedBigInteger('parent_id')->nullable();
//            $table->foreign('parent_id')->references('id')->on('skills');
//            $table->timestamps();
        });

//        Schema::create('skilltree_student', function (Blueprint $table) {
//            $table->unsignedBigInteger('skilltree_id');
//            $table->foreign('skilltree_id')->references('id')->on('skilltrees');
//            $table->unsignedBigInteger('student_id');
//            $table->foreign('student_id')->references('id')->on('students');
//
//            $table->index(['skilltree_id', 'student_id']);
//        });

//        Schema::create('skilltree_teacher', function (Blueprint $table) {
//            $table->unsignedBigInteger('skilltree_id');
//            $table->foreign('skilltree_id')->references('id')->on('skilltrees');
//            $table->unsignedBigInteger('teacher_id');
//            $table->foreign('teacher_id')->references('id')->on('teachers');
//
//            $table->index(['skilltree_id', 'teacher_id']);
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
        Schema::dropIfExists('skilltrees');
    }
};
