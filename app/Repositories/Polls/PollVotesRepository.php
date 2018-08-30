<?php

namespace App\Repositories\Polls;

use Str;
use Item;
use Request;
use Collection;
use Carbon\Carbon;
use RepositoryManager;
use App\Models\Poll\Poll;
use App\Models\Poll\Vote as PollVote;
use HZ\Laravel\Organizer\App\Contracts\RepositoryInterface;

class PollVotesRepository extends RepositoryManager implements RepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    const MODEL = PollVote::class;

    /**
     * {@inheritDoc}
     */
    const TABLE = 'poll_votes';
    
    /**
     * {@inheritDoc}
     */
    const TABLE_ALIAS = 'pv';

    /**
     * {@inheritDoc}
     */
    protected function records(Collection $records): Collection 
    {
        return $records->map(function ($record) {
            // if ($record->created_at) {
            //     $record->created_at = Carbon::parse($record->created_at)->format('d-m-Y');
            // }

            if (! empty($record->creatorImage)) {
                if (! filter_var($record->creatorImage, FILTER_VALIDATE_URL) && ! Str::startsWith($record->creatorImage, 'data:image')) {
                    $record->creatorImage = url($record->creatorImage);
                }
            }

            if ($record->answerImage) {
                $record->answerImage = url($record->answerImage);
            }

            return $record;
        });
    }

    /**
     * {@inheritDoc}
     */
    protected function setData($poll, Request $request)
    {
    } 

    /**
     * {@inheritDoc}
     */
    public function get(int $id): Item
    {
        return new Item;
    }

    /**
     * {@inheritDoc}
     */
    protected function select()
    {
        foreach (['id', 'comment', 'created_at'] as $column) {
            $this->select->replace($column, $this->column($column));
        }

        if ($this->select->has('answer')) {
            $this->select->replace('answer', $this->column('poll_answer as answer'), $this->column('poll_answer_image as answerImage'));
        }

        if ($this->select->has('creator')) {
            $this->select->remove('creator');

            $this->join('users as u', 'u.id', '=', 'pv.created_by');

            $this->select->add('pv.created_by');

            $this->select->add($this->raw('CONCAT(u.first_name, " ", u.last_name) as creatorName'), 'u.image as creatorImage');
        }
    } 
    
    /**
     * {@inheritDoc}
     */
    protected function filter() 
    {
        if ($pollId = $this->option('poll_id')) {
            $this->where('pv.poll_id', $pollId);
        }

        if ($answerId = $this->option('answer_id')) {
            $this->where('pv.poll_answer_id', $answerId);
        }
    }  
}
