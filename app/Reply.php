<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        "reply",
        "survey_id",
        "user_id",
        "scored"
    ];

    protected $casts = [
        'reply' => 'array',
    ];

    /** Relationships */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /** accesor */

    public function getReplyAttribute($value)
    {
        return json_decode(substr(stripslashes($value), 1, -1));
    }
}
