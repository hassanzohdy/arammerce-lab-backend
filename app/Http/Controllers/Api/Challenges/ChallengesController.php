<?php
namespace App\Http\Controllers\Api\Challenges;

use Request;
use ApiController;

class ChallengesController extends ApiController
{
    /**
     * Get list
     *
     * @return string
     */
    public function index(Request $request)
    {
        return $this->success([
            'challenges' => $this->challenges->list([
                'select' => ['id', 'title', 'starts_at', 'ends_at', 'tags', 'rewards'],
                'status' => 'enabled',
            ]),
        ]);
    }
}
