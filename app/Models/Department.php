<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ["title", "description", "icon"];

    public function quizzes() {
        return $this->belongsToMany(Quiz::class);
    }
}
