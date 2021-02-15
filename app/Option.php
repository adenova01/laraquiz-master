<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Option extends Model
{
    
    protected $fillable=['idq','answer','score','correct_answer'];
}
