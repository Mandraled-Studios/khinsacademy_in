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
            $table->foreignId('quiz_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->text('question_part1');
            $table->string('quesImage')->nullable();
            $table->text('question_part2')->nullable();
            $table->string('option1');
            $table->string('option2');
            $table->string('option3');
            $table->text('option4')->nullable();
            $table->text('option5')->nullable();
            $table->float('question_marks', 4, 2)->nullable();
            $table->tinyInteger('correct_answer');
            $table->boolean('shuffle')->default(false);
            $table->timestamps();
            $table->softDeletes();
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
