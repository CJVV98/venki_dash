<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "course_id",
        "user_id",
        "comment",
        "score"
    ];

    /** Relationship */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
