<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentQuiz extends Model
{
    use HasFactory;

    protected $table = "department_quiz";
    protected $fillable = ["quiz_id", "department_id"];
}
