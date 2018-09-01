<?php
namespace App\Models\Task;

use Model;

class Task extends Model
{
    /**
     * {@inheritDoc} 
    */
    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    /**
     * {@inheritDoc} 
    */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * {@inheritDoc} 
    */
    public function supervisors()
    {
        return $this->hasMany(Supervisor::class);
    }
}
