<?php

namespace App\Http\Controllers\Voyager;

use TCG\Voyager\Http\Controllers\VoyagerController as BaseVoyagerController;
use App\Quis;

class VoyagerController extends BaseVoyagerController
{
    public function index()
    {
        $quis=Quis::where('quiz_price',0)->get();
        return view('vendor/voyager/index',compact('quis')) ;
        //return view('vendor/voyager/master');
    }
}
