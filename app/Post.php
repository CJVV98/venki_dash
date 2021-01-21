<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'post'
    ];

    /**Relationships */
    public function medias()
    {
        return $this->hasMany(PostMedia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
