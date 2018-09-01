<?php

return [
    /**
     * This is mainly used to override the max key length
     * @visit https://laravel-news.com/laravel-5-4-key-too-long-error
     */
    'database' => [
        'mysql' => [
            'defaultStringLength' => 160,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Repositories
    |--------------------------------------------------------------------------
    |
    | The repositories section will be mainly used for records retrieval... fetching records from database
    | It will also be responsible for inserting/updating and deleting from database 
    |
    */
    'repositories' => [
        'polls' => App\Repositories\Polls\PollsRepository::class,
        'pollVotes' => App\Repositories\Polls\PollVotesRepository::class,
        'answers' => App\Repositories\Polls\AnswersRepository::class,
        'users' => App\Repositories\Users\UsersRepository::class,
        'posts' => App\Repositories\Posts\PostsRepository::class,
        'postComments' => App\Repositories\Posts\PostCommentsRepository::class,
        'tags' => App\Repositories\Posts\TagsRepository::class,
        'events' => App\Repositories\Events\EventsRepository::class,
        'tasks' => App\Repositories\Tasks\TasksRepository::class,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Macroable classes
    |--------------------------------------------------------------------------
    |
    | Here you can set your macros classes that will be used to be 
    | The key will be the original class name that will be extends 
    | The value will be the macro class that will be used to extend the original class 
    |
    */
    'macros' => [
        Illuminate\Support\Str::class => HZ\Laravel\Organizer\App\Macros\Support\Str::class,
        Illuminate\Support\Arr::class => HZ\Laravel\Organizer\App\Macros\Support\Arr::class,
        Illuminate\Http\Request::class => HZ\Laravel\Organizer\App\Macros\Http\Request::class,
        Illuminate\Support\Collection::class => HZ\Laravel\Organizer\App\Macros\Support\Collection::class,
        Illuminate\Database\Query\Builder::class => HZ\Laravel\Organizer\App\Macros\Database\Query\Builder::class,
        Illuminate\Database\Schema\Blueprint::class => HZ\Laravel\Organizer\App\Macros\Database\Schema\Blueprint::class,
    ],
];