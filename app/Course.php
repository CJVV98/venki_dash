<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'trailer',
        'price'
    ];

    protected $appends = ["duration"];


    /** Accessor */

    public function getDurationAttribute()
    {
        return $this->lessons()->sum('duration');
    }

    /** RELATIONSHIPS */

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'courses_categories');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_courses');
    }
}
