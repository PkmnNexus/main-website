<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the articles associated with the source.
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}