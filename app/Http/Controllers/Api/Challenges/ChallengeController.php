<?php
namespace App\Http\Controllers\Api\Challenges;

use ApiController;

class ChallengeController extends ApiController
{
    /**
     * Get post details
     *
     * @param  int $id 
     * @return string
     */
    public function show(int $id)
    {
        if (! $this->challenges->has($id)) {
            return $this->badRequest('not-found');
        }
        
        return $this->success([
            'challenge' => $this->challenges->get($id),
        ]);
    }
    /**
     * Get post details
     *
     * @param  int $id 
     * @return string
     */
    public function participate(int $id)
    {
        if (! $this->challenges->has($id)) {
            return $this->badRequest('not-found');
        }

        $this->challenges->participate($id, user()->id);

        return $this->success([
            'challenge' => $this->challenges->get($id),
        ]);
    }
}
