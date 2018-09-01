<?php
namespace App\Http\Controllers\Api\Management\Posts;

class TagsController extends \AdminApiController
{
    /**
     * Controller info
     *
     * @var array
     */
    protected $controllerInfo = [
        'repository' => 'tags',
        'listOptions' => [
            'select' => ['id', 'name', 'image'],
        ],
        'rules' => [
            'all' => [
                'name' => 'required',
            ],
            'store' => [
                'image' => 'required',
            ],
        ],
    ];
}
