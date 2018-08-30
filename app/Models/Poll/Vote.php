<?php
namespace App\Models\Poll;

use Model;

class Vote extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'poll_votes';
    
    /**
     * {@inheritDoc} 
    */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
