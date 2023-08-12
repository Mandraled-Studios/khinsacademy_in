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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('occasion_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('description');
            $table->integer('max_marks');
            $table->integer('max_mins');
            $table->integer('attempts');
            $table->boolean('shuffle')->default(false);
            $table->boolean('separate_marks')->default(false);
            $table->string('quespdf')->nullable();
            $table->string('keypdf')->nullable();
            $table->boolean('publish_status');
            $table->timestamp('published_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
