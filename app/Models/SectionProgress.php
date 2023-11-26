<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SectionProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'progress_id',
        'quiz_section_id',
        'attended_ques_count',
        'answered_correctly',
        'score',
        'exam_date',
        'start_time',
        'scheduled_end_time',
        'actual_end_time',
        'userAnswer',
    ];
    
    /**
     * Get the progress that owns the SectionProgress
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function progress(): BelongsTo
    {
        return $this->belongsTo(Progress::class);
    }
}
