<?php

namespace App\Models;

use App\Models\QuizSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ["quiz_id", "question_part1", "quesImage", 
    "question_part2", "option1", "option2", "option3", 
    "option4", "option5", "question_marks", 
    "correct_answer", "shuffle"];

    /**
     * Get the quiz section that owns the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(QuizSection::class);
    }
}
