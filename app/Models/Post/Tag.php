<?php
namespace App\Models\Post;

use Model;

class Tag extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'tags';
    
    /**
     * {@inheritDoc} 
    */
    public function post()
    {
        return $this->belongsToMany(Poll::class);
    }
}
