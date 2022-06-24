<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webcrawler extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
    public function crawls()
    {
        return $this->hasMany('App\Models\Crawl');
    }
}
