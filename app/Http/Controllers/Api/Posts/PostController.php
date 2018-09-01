<?php
namespace App\Http\Controllers\Api\Posts;

use ApiController;

class PostController extends ApiController
{
    /**
     * Get post details
     *
     * @param  int $id 
     * @return string
     */
    public function show(int $id)
    {
        if (! $this->posts->has($id)) {
            return $this->badRequest('not-found');
        }

        return $this->success([
            'post' => $this->posts->get($id),
        ]);
    }
}
