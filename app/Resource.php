<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'lesson_id',
        'audio',
        'video',
        'document',
        'order'
    ];
}
