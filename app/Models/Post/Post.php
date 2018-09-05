<?php
namespace App\Models\Post;

use Model;

class Post extends Model
{
    /**
     * {@inheritDoc} 
    */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
