<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PaketMuridController extends Controller
{

    public function getDetailBuyPaket($id)
    {
        return $myquisfromPaket=DB::table('quiss')
            ->select(['*','quiss.id as id_quiss'])
            ->join('groups','quiss.id_groups','=','groups.id')
            ->join('transaksipakets','transaksipakets.id_groups','=','groups.id')
            ->where('transaksipakets.id_user',Auth::user()->id)
            ->where('groups.id',$id)
            ->get();
    }

    public function getBuyPakets()
    {
        return $getbuypaket=DB::table('transaksipakets')
            ->where('id_user',Auth::user()->id)
            ->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups=Group::paginate(10);
        $getbuypaket=$this->getBuyPakets();
        return view('paketmurid.index',compact('groups','getbuypaket'));
    }

     /**
     * Beli Paket redirect ke WA dengan inforamsi nama Paket
     *
     * @return \Illuminate\Http\Response
     */
    public function beliPaket($id){
        $group=Group::findOrFail($id);
        $url_wa="https://wa.me/6281329983555?text=";
        $pesan="Hai Saya ".Auth::user()->name." Dengan Email ".Auth::user()->email." Ingin Membeli Paket ".$group->group_name." Yang Berharga : Rp ".number_format($group->price,2,',','.');
        $url=$url_wa.urlencode($pesan);
        return redirect($url);
    }
    
    public function detailPaket($id)
    {
        $getDetailBuyPaket=$this->getDetailBuyPaket($id);
        return view ('paketmurid.detailpaket',compact('getDetailBuyPaket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
