<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the articles associated with the tag.
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}