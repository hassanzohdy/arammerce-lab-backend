<?php
namespace App\Http\Controllers\Api\Polls;

use Request;
use ApiController;

class PollsController extends ApiController
{
    /**
     * Get list
     *
     * @return string
     */
    public function index(Request $request)
    {
        return $this->success([
            'polls' => $this->polls->list([
                'select' => ['id', 'title', 'created_at', 'createdBy', 'ends_at', 'voted', 'totalVotes', 'status', 'answers'],
            ]),
        ]);
    }

    /**
     * Determine whether the passed values are valid
     *
     * @return mixed
     */
    public function show(Request $request, $id)
    {
        if (! $this->polls->has($id)) {
            return $this->badRequest('Not Found!');
        }

        return $this->success([
            'poll' => $this->polls->getPollWithAnswers($id),
        ]);
    }

    /**
     * Create new vote
     * 
     */
    public function vote(Request $request, $pollId)
    {
        if (! $this->polls->has($pollId)) {
            return $this->badRequest('Not Found!');
        }

        $poll = (object) $this->polls->getPollWithAnswers($pollId);

        if ($poll->allow_more_answers && $request->custom_answer && ! ($request->answer || $request->answers)) {
            $request->poll_id = $pollId;

            $request->id = null; // just to disable the /pollId in the uri

            $request->answer = $request->custom_answer['answer'];
            $request->image = $request->custom_answer['image'];

            $answer = $this->answers->create($request);
            
            $request->answer = $answer;

            $this->polls->vote($pollId, $request);

            return $this->show($request, $pollId);
        }

        $answerExists = true;
        $answers = (array) ($request->answer ?: $request->answers);

        $pollAnswersIds = $poll->answers->pluck('id')->toArray();

        foreach ($answers as $answerId) {
            if (! in_array($answerId, $pollAnswersIds)) {
                $answerExists = false;
                break;
            }
        }

        if (! $answerExists) {
            return $this->badRequest('Invalid Voting!');
        }

        foreach ($poll->answers as $answer) {
            if (in_array($answer['id'], $answers)) {
                $request->answer = $answer;
                $this->polls->vote($pollId, $request);
            }
        }

        return $this->show($request, $pollId);
    }

    /**
     * Get all votes for the given poll and answer id
     * 
     * @return string
     */
    public function votes($pollId, $answerId)
    {
        return $this->success([
            'votes' => $this->pollVotes->list([
                'select' => ['creator', 'answer', 'comment', 'created_at'],
                'poll_id' => $pollId,
                'answer_id' => $answerId,
            ]),
        ]);
    }
}
