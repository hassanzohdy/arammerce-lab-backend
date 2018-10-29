<?php
namespace App\Models\Challenge;

use BaseModel;

class Tag extends BaseModel
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'challenge_tags';
    
    /**
     * {@inheritDoc} 
    */
    public function Challenge()
    {
        return $this->belongsToMany(Challenge::class);
    }
}
