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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->json('options');  // Answer options
            $table->integer('correct_answer_index'); // Correct answer index
            $table->unsignedBigInteger('subject_id')->nullable(); // Foreign key for a subject
            $table->unsignedBigInteger('chapter_id')->nullable(); // Foreign key for chapter
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
