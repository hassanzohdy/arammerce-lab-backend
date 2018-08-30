<?php
namespace App\Models\Poll;

use Model;

class Poll extends Model
{
    /**
     * {@inheritDoc} 
    */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
