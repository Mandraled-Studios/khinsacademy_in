<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        "quiz_id", "user_id", "submission_status", 
        "attended_ques_count", "answered_correctly",
        "score", "exam_date", "start_time", "scheduled_end_time",
        "actual_end_time", "userAnswer", "attempts_remain"
    ];
}
