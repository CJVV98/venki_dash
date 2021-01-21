<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes;

    /** Relationships */

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
