<?php
namespace App\Http\Controllers\Api\Management\Challenges;

class ChallengesController extends \AdminApiController
{
    /**
     * Controller info
     *
     * @var array
     */
    protected $controllerInfo = [
        'repository' => 'challenges',
        'listOptions' => [
            'select' => ['id', 'title', 'starts_at', 'ends_at', 'status'],
        ],
        'rules' => [
            'all' => [
                'title' => 'required',
            ],
        ],
    ];
}
