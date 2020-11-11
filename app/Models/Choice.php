<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $guarded = [''];

    /** RELATIONSHIP **/
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
