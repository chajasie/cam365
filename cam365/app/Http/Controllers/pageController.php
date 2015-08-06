<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class pageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //Startpage
        return view('pages.startpage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function jantofilm()
    {
          $interval = 30;
        	$fileName = 'livepic/current.jpg';
        	//$url = 'http://10-0-37-25--rhb82vu0a906y1taeekg.vpncam.ch/record/current.jpg';
        	$url = "10-0-37-25--rhb82vu0a906y1taeekg.vpncam.ch";
        	$fp = fsockopen($url , 80, $errno, $errstr, 5);
        	if ($fp){
        		$exists = true;
        	}else{
        		$exists = false;
        		$files = scandir('archiv/middle/',0);
        		$picCount = -1;
        		$months = array('01','02','03','04','05','06','07','08','09','10','11','12');
        		for($i=0;$i<count($files);$i++){
        			if(!is_dir($files[$i])){
        				$folderYear = $files[$i];
        				$yearFiles = scandir('archiv/middle/' . $folderYear,0);

        				for($y=0;$y<count($yearFiles);$y++){
        					if (in_array($yearFiles[$y], $months)) {
        						$monthFolder = $yearFiles[$y];
        						$monthFiles = scandir('archiv/middle/' . $folderYear . '/' .  $yearFiles[$y], 0);
        						for($m=0;$m<count($monthFiles);$m++){
        							if(strpos($monthFiles[$m],'.jpg')){
        										$picCount++;
        										$pics[$picCount] = 'archiv/middle/' . $folderYear . '/' .  $monthFolder . '/' . $monthFiles[$m];
        							}
        						}
        					}
        				}
        			}
        		}
        		$currentPic = $picCount;
      	 }

        if($exists){
      	 	$file = filectime('livepic/current.jpg');
      		if(time() - $file > $interval){
      			copy('http://10-0-37-25--rhb82vu0a906y1taeekg.vpncam.ch/record/current.jpg', 'livepic/current.jpg');
      		}
      	}else{
      		$fileName = $pics[$currentPic];
      	}

        //Zeigt die Seite von Jantofilm
        return view('pages.jantofilm', ['fileName' => $fileName]);
    }
    public function jantofilmArchiv(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
