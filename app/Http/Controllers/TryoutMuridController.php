<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quis;
use App\Qbank;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TryoutMuridController extends Controller
{
    private function myTryoutLoad(){
        return $mytryout=DB::table('quiss')
        ->join('transaksi_quiz','transaksi_quiz.id_quiz','=','quiss.id')
        ->where('transaksi_quiz.id_user',Auth::user()->id);
    }
    public function loadQuestion($id){
        return $question=DB::table('qbanks')
        ->join('options','options.idq','=','qbanks.id')
        ->where('qbanks.id',$id)
        ->get();
    }
    public function index(){
        $quis=Quis::all();
        $mytryout=$this->myTryoutLoad()->select('id_quiz')->get();
        return view('tryoutmurid.index',compact('quis','mytryout'));
    }
    public function mulai_ujian($id){
        $quis=Quis::findOrFail($id);
        $arrQuest=explode(',',$quis->id_questions);
        $quest=$this->loadQuestion($arrQuest[0]);
        return view('ujianAttempt.mulaiujian',compact('quis','quest'));
    }
    public function beli_quis($id){
        $quis=Quis::findOrFail($id);
        $url_wa="https://wa.me/6281329983555?text=";
        $pesan="Hai Saya ".Auth::user()->name." Dengan Email ".Auth::user()->email." Ingin Membeli Tryout ".$quis->quiz_name." Yang Berharga : Rp ".number_format($quis->quiz_price,2,',','.');
        $url=$url_wa.urlencode($pesan);
        return redirect($url);
    }
    public function my_tryout(){
        $mytryout=$this->myTryoutLoad()->get();
        return view('tryoutmurid.mytryout',compact('mytryout'));
    }
}
