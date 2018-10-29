<?php
namespace App\Models\Challenge;

use BaseModel;

class Reward extends BaseModel
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'challenge_rewards';
    
    /**
     * {@inheritDoc} 
    */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
