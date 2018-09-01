<?php
namespace App\Http\Controllers\Api\Posts;

use ApiController;

class PostCommentsController extends ApiController
{
    /**
     * Get post comments
     *
     * @param  int $postId 
     * @return string
     */
    public function index(int $postId)
    {
        if (! $this->posts->has($id)) {
            return $this->badRequest('not-found');
        }

        return $this->success([
            'comments' => $this->postComments->list([
                'select' => ['id', 'created_at', 'createdBy', 'comment'],
                'post_id' => $id,
            ]),
        ]);
    }
}
