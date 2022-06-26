<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the main webcrawler for image
     */
    public function webcrawler()
    {
        return $this->belongsTo('App\Models\Webcrawler');
    }
}
