<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Resultujian extends Model
{
    protected $table="resultujians";
    protected $fillable=['id_quis','id_user','start_time','score_obtained','percentage_obtained','result_status'];

    public function scopeSomeUsers($query){
        if(Auth::user()->role_id!=4){
            return $query;
        }else{
            return $query->where('id_user',Auth::user()->id);
        }
    }
}
