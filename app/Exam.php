<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "exam",
        "lesson_id"
    ];

    /** accesors */
    public function getExamAttribute($value)
    {
        return json_decode($value);
    }
    /** mutatos */

    public function setExamAttribute($value)
    {
        $this->attributes['exam'] = json_encode($value);
    }
}
