<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webcrawler extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the images for main webcrawl
     */
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
    /**
     * Get the crawled urls for main webcrawl
     */
    public function crawls()
    {
        return $this->hasMany('App\Models\Crawl');
    }
}
