<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Models\User;
use Illuminate\Support\Facades\Hash;
class RegisterController extends Controller
{
    public function register(){
        return view('register');
    }

    public function registrasiUser(Request $request){
        //dd($request->post());
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user=User::create([
            'name'=>$request->post()['name'],
            'email'=>$request->post()['email'],
            'password'=>Hash::make($request->post()['password']),
            'role_id'=>'4',
            'avatar'=>'users/default.png'
        ]);
        
        return redirect('/tryout')->with([
            'message'    => __('voyager::generic.successfully_added_new')."Berhasil Mendaftar",
            'alert-type' => 'success',
        ]);
    }
}
