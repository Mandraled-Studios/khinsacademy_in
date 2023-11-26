<?php

namespace App\Models;

use App\Models\Progress;
use App\Models\Question;
use App\Models\QuizSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quiz extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ["title", "slug", "description", "max_marks", "max_mins", 
    "attempts", "shuffle", "separate_marks", "quespdf", "keypdf", "publish_status", "published_at"];

    /**
     * Get all of the questions for the Quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get all of the sections for the Quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections(): HasMany
    {
        return $this->hasMany(QuizSection::class);
    }

    /**
     * Get all of the progresses for the Quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function progresses(): HasMany
    {
        return $this->hasMany(Progress::class);
    }

    /**
     * The departments that belong to the Quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'department_quiz', 'department_id', 'quiz_id');
    }
}
