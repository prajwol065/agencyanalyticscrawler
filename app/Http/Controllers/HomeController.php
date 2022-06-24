<?php

namespace App\Http\Controllers;

use App\Models\Webcrawler;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $webcrawler = Webcrawler::all();
        if($webcrawler->isEmpty()){
            return view('home');
        }else{
            return redirect()->route('webcrawl.index');
        }

    }
}
