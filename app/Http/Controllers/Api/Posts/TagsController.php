<?php
namespace App\Http\Controllers\Api\Posts;

use ApiController;

class TagsController extends ApiController
{
    /**
     * Get tags list
     *
     * @return mixed
     */
    public function tagsList()
    {
        return $this->success([
            'tags' => $this->tags->list([
                'select' => ['id', 'name', 'image'],
            ]),
        ]);
    }
}
