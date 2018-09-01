<?php
namespace App\Models\Task;

use Model;

class User extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'task_supervisors';
    
    /**
     * {@inheritDoc} 
    */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
