<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Jawbanmurid extends Model
{
    protected $fillable =['jawaban','id_qbanks','id_quis','id_user','countdown_time'];
}
