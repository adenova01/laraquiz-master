<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Qbank extends Model
{
    protected $table ="qbanks";

    public function scopeSomeUsers($query){
        return $query->where('inserted_by',Auth::user()->id);
    }

}
