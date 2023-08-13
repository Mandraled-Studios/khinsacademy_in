<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        "quiz_id", "user_id", "submission_status", 
        "attended_ques_count", "answered_correctly",
        "score", "exam_date", "start_time", "scheduled_end_time",
        "actual_end_time", "userAnswer", "attempts_remain"
    ];

    /**
     * Get the quiz that owns the Progress
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the user that owns the Progress
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
