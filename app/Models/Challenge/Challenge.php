<?php
namespace App\Models\Challenge;

use Model;
use App\Models\User\User;
use App\Models\Post\Tag as baseTag;

class Challenge extends Model
{
    /**
     * {@inheritDoc} 
    */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'challenge_participants', 'challenge_id', 'user_id');
    }

    /**
     * {@inheritDoc} 
    */
    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }
    
    /**
     * {@inheritDoc} 
    */
    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
    
    /**
     * {@inheritDoc} 
    */
    public function tags()
    {
        return $this->belongsToMany(baseTag::class, 'challenge_tags', 'challenge_id', 'tag_id');
    }
}
