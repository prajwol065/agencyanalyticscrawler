<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crawl extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function webcrawl()
    {
        return $this->belongsTo('App\Models\Webcrawl');
    }
}

