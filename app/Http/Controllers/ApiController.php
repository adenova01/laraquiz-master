<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jawbanmurid;
use App\ResultUjian;
use Symfony\Component\Console\Question\Question;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data=DB::table('qbanks')
        ->join('options','options.idq','=','qbanks.id')
        ->get();
        return new QuestionResource($data);
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
        //dd(count($request->post()[0]));
        
        foreach ($request->post() as $row) {
            $jwb=Jawbanmurid::create([
                'id_user'=>$row['id_user'],
                'id_quis'=>$row['id_quis'],
                'id_qbanks'=>$row['id_qbanks'],
                'jawaban'=>$row['id_option']
            ]);
        }
        if($jwb){
            $response=['status'=>'OKE', 'code'=>'200' ];
        }else{
            $response=['status'=>'FAIL', 'code'=>'404' ];
        }
        return new QuestionResource($response);
    }

    public function storeResult(Request $request)
    {
        
        $data=$request->post();
        $result=ResultUjian::create([
            'id_quis'=>$data['id_quis'],
            'id_user'=>$data['id_user'],
            'start_time'=>$data['start_time'],
            'score_obtained'=>$data['score'],
            'percentage_obtained'=>$data['percentage_obtained'],
            'result_status'=>$data['resultStatus']
        ]);
        if($result){
            $response=['status'=>'OKE', 'code'=>'200' ];
        }else{
            $response=['status'=>'FAIL', 'code'=>'404' ];
        }
        return new QuestionResource($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=DB::table('qbanks')
        ->join('options','options.idq','=','qbanks.id')
        ->where('qbanks.id',$id)
        ->get();
        return new QuestionResource($data);
    }

    public function showPaket($id)
    {
        $data=DB::table('quiss')
            ->where('id_groups',$id)
            ->get();
        return new QuestionResource($data);
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
