<?php

namespace App\Repositories\Polls;

use Str;
use Request;
use Collection;
use RepositoryManager;
use App\Models\Poll\Answer;
use App\Items\Poll\Answer as AnswerItem;
use HZ\Laravel\Organizer\App\Contracts\RepositoryInterface;

class AnswersRepository extends RepositoryManager implements RepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    const MODEL = Answer::class;

    /**
     * {@inheritDoc}
     */
    const TABLE = 'poll_answers';
    
    /**
     * {@inheritDoc}
     */
    const TABLE_ALIAS = 'pa';

    /**
     * {@inheritDoc}
     */
    protected function records(Collection $records): Collection 
    {
        return $records->map(function ($record) {
            return new AnswerItem($record);
        });
    }

    /**
     * {@inheritDoc}
     */
    protected function setData($answer, Request $request)
    {
        if ($request->id) {
            $answer->id = $request->id;
        }

        $answer->poll_id = $request->poll_id;
        $answer->answer = $request->answer;
        $answer->comment = (string) $request->comment;

        if ($request->image) {
            $answer->image = $request->image->store('poll/answers');
        } elseif ($request->image_url) {
            $answer->image = Str::removeFirst(url(''), $request->image_url);
        }

        if (! $answer->image) {
            $answer->image = '';
        }
    } 
    
    /**
     * {@inheritDoc}
     */
    public function get(int $id): \Item
    {
        return new \Item;
    }

    /**
     * {@inheritDoc}
     */
    protected function select()
    {
        foreach (['id', 'answer', 'image'] as $column) {
            $this->select->replace($column, $this->column($column));
        }

        if ($this->select->has('totalVotes')) {
            $this->select->replace('totalVotes', $this->raw('(SELECT COUNT(pv.id) FROM poll_votes as pv WHERE pa.id = pv.poll_answer_id) as totalVotes'));
        }
    } 
    
    /**
     * {@inheritDoc}
     */
    protected function filter() 
    {
        if ($polls = (array) $this->option('poll_id')) {
            $this->whereIn('pa.poll_id', $polls);
        }
    }  
}
