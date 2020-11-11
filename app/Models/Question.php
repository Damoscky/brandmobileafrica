<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [''];

    /** RELATIONSHIP **/
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function choice()
    {
        return $this->hasMany(Choice::class);
    }

}
