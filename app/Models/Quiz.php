<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ["title", "slug", "description", "max_marks", "max_mins", 
    "attempts", "shuffle", "separate_marks", "quespdf", "keypdf", "publish_status", "published_at"];
}
