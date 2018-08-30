<?php
namespace App\Http\Controllers\Api\Management\Users;

class UsersController extends \AdminApiController
{
    /**
     * Controller info
     *
     * @var array
     */
    protected $controllerInfo = [
        'repository' => 'users',
        'listOptions' => [
            'select' => ['id', 'first_name', 'last_name', 'user_name',  'email', 'job_title', 'job_title_level', 'country', 'city', 'birthdate', 'created_at'],
        ],
    ];
}
