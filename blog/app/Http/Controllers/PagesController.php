<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PagesController extends Controller {

	//Index
    public function index(){
        
        $lessons = ['ersti lektion', 'zweiti lektion'];
        $name = 'Ronald Aus der Au';
        //Call view
        return view('pages.home',  compact('lessons', 'name'));
    }
    //About
    public function about(){
        return view('pages.about');
    }

}