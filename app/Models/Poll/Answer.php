<?php
namespace App\Models\Poll;

use Model;

class Answer extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'poll_answers';
    
    /**
     * {@inheritDoc} 
    */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
