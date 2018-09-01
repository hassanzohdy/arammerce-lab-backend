<?php
namespace App\Http\Controllers\Api\Management\Polls;

class TasksController extends \AdminApiController
{
    /**
     * Controller info
     *
     * @var array
     */
    protected $controllerInfo = [
        'repository' => 'tasks',
        'listOptions' => [
            'select' => ['id', 'title', 'starts_at',  'ends_at', 'created_at', 'priority', 'priority_level'],
        ],
        'rules' => [
            'all' => [
                'title' => 'required',
                'starts_at' => 'required',
                'priority' => 'required',
                'priority_level' => 'required',
                'description' => 'required',
                'ends_at' => 'required',
            ],
        ],
    ];
}
