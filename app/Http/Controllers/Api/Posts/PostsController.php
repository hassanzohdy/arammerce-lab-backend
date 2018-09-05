<?php
namespace App\Http\Controllers\Api\Posts;

use Request;
use ApiController;

class PostsController extends ApiController
{
    /**
     * Get list
     *
     * @return string
     */
    public function index(Request $request)
    {
        return $this->success([
            'posts' => $this->posts->list([
                'select' => ['id', 'title', 'created_at', 'createdBy', 'tags'],
                'status' => 'active',
            ]),
        ]);
    }

    /**
     * Create new post
     *
     * @param \Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $post = $this->posts->create($request);
        return $this->success([
            'post' => [
                'id' => $post->id,
            ],
        ]);
    }

    /**
     * Update post
     *
     * @param int $Id
     * @param \Request $request
     * @return mixed
     */
    public function update(int $id, Request $request)
    {
        $this->posts->update($id, $request);
        return $this->success([
            'postId' => $id,
        ]);
    }
}
