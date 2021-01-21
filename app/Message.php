<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
    ];

    /** Relationships */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
