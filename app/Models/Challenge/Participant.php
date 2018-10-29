<?php
namespace App\Models\Challenge;

use BaseModel;

class Participant extends BaseModel
{
    /**
     * {@inheritDOc}
     */
    const CREATED_AT = null;

    /**
     * {@inheritDOc}
     */
    const UPDATED_AT = null;
 
    /**
     * {@inheritDoc}
     */
    protected $table = 'challenge_participants';
   
    /**
     * {@inheritDoc} 
    */
    public function challenge()
    {
        return $this->belongsToMany(Challenge::class);
    }
}
