<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question', 'survey_id', 'category_id'];

    /**  Relationships */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
