<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Text;
use App\Qbank;

class ImportQbankController extends Controller
{
    public function __construct(){
        $this->phpWord = new PhpWord();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'Qbank'   => 'mimes:docx'
        ]);

        $filenameWithExt = $request->file('Qbank')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('Qbank')->getClientOriginalExtension();
        $filenameSave = $filename.'_'.time().'.'.$extension;
        $path = $request->file('Qbank')->storeAs('public/QbankFile', $filenameSave);

        if($path){

            $xmlString = '';
            try{

                $objReader = IOFactory::createReader('Word2007');

                $source = storage_path('app\public\QbankFile/'.$filenameSave);

                $phpRead = $objReader->load($source);
                $sections = $phpRead->getSections();

                foreach ($sections as $key => $value) {
                    $sectionElement = $value->getElements();
                    foreach ($sectionElement as $elementKey => $elementValue) {
                        $element = $elementValue->getElements();
                        foreach ($element as $keyelement => $value) {
                            $wordLoadContent = $value->getText();

                            // print_r(simplexml_load_string($wordLoadContent));

                            $xmlString = $wordLoadContent;
                            echo $xmlString;
                            // print_r(str_word_count($xmlString));

                            // $xml = simplexml_load_string($xmlString) or die ("error: create object");
                            // print_r($xml);
                        }
                    }
                }


                
                // $myXMLData =
                // "<Qbank><category>q</category><questiontype>sadasd</questiontype><paragraph>asdas</paragraph><question>asdas</question></Qbank>";

                // $xml=simplexml_load_string($myXMLData) or die("Error: Cannot create object");
                // echo "<pre>";
                // print_r($xml);
                // echo "</pre>";

            }catch(Exception $e){
                return back()
                ->with('message','File upload error '.$e);
            }

            // return back()
            // ->with('message','File '.$filename.'.'.$extension.' has been uploaded.');
        }
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
