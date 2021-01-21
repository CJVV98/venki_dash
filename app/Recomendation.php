<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recomendation extends Model
{
    use SoftDeletes;

    protected $fillable = ["user_id"];

    /** Relationships */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_recomendations');
    }
}
