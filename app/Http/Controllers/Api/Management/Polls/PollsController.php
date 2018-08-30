<?php
namespace App\Http\Controllers\Api\Management\Polls;

class PollsController extends \AdminApiController
{
    /**
     * Controller info
     *
     * @var array
     */
    protected $controllerInfo = [
        'repository' => 'polls',
        'listOptions' => [
            'select' => ['id', 'title', 'status',  'type', 'ends_at', 'requires_comment'],
        ],
        'rules' => [
            'all' => [
                'title' => 'required',
                'type' => 'required',
                'ends_at' => 'required',
            ],
        ],
    ];
}
