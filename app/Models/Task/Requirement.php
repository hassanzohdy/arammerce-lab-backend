<?php
namespace App\Models\Task;

use Model;

class Requirement extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'task_requirements';
    
    /**
     * {@inheritDoc} 
    */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
