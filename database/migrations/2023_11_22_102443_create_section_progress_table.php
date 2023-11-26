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
        Schema::create('section_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('progress_id')->constrained()->onUpdate('cascade');
            $table->foreignId('quiz_section_id')->constrained()->onUpdate('cascade');
            $table->integer('attended_ques_count')->nullable();
            $table->integer('answered_correctly')->nullable();
            $table->float('score', 8, 2)->nullable();
            $table->date('exam_date');
            $table->time('start_time');
            $table->time('scheduled_end_time');
            $table->time('actual_end_time')->nullable();
            $table->text('userAnswer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_progress');
    }
};
