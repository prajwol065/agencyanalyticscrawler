<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crawl extends Model
{
    use HasFactory;
    protected $guarded = [];
     /**
     * Get the main webcrawl for scrapped urls
     */
    public function webcrawl()
    {
        return $this->belongsTo('App\Models\Webcrawl');
    }
}

