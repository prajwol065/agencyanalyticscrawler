<?php

namespace App\Http\Controllers;

use DOMDocument;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function show()
    {
        $images = Image::all();
        $uniques = $images->unique('image_url');

        if ($images->isEmpty()) {
            session()->flash('message','Website has not been crawled!!');
            return redirect()->route('home');
        } else {
        return view('webcrawl.images.show', ['images' => $uniques]);
        }

        /* echo "unique images2:".$count; */
    }
}
