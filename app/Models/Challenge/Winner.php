<?php
namespace App\Models\Challenge;

use Model;

class Winner extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'challenge_winners';
    
    /**
     * {@inheritDoc} 
    */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
