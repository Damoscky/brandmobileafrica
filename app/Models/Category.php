<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [''];

    /**RELATIONSHIP **/
    public function user()
    {
        return $this->hasMany(Question::class);
    }
}
