<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'photo',
        'description',
        'video',
        'pdf',
    ];

    /** Relationships */

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_categories');
    }
}
