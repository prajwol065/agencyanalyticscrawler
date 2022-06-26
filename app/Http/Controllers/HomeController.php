<?php

namespace App\Http\Controllers;

use App\Models\Webcrawler;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Displays the HomePage
     *
     * @return \Illuminate\View\View
     */
    public function index(){
        $webcrawler = Webcrawler::all();
        if($webcrawler->isEmpty()){
            return view('home');
        }else{
            return redirect()->route('webcrawl.index');
        }

    }
}
