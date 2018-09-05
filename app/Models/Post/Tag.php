<?php
namespace App\Models\Post;

use Model;

class Tag extends Model
{
    /**
     * {@inheritDoc} 
    */
    public function post()
    {
        return $this->belongsToMany(Poll::class);
    }
}
