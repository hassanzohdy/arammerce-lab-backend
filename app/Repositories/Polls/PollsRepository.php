<?php

namespace App\Repositories\Polls;

use Str;
use Request;
use Collection;
use Carbon\Carbon;
use RepositoryManager;
use App\Models\Poll\Poll;
use App\Models\Poll\Vote as PollVote;
use App\Items\Poll\Poll as PollItem;
use HZ\Laravel\Organizer\App\Contracts\RepositoryInterface;

class PollsRepository extends RepositoryManager implements RepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    const MODEL = Poll::class;

    /**
     * {@inheritDoc}
     */
    const TABLE = 'polls';
    
    /**
     * {@inheritDoc}
     */
    const TABLE_ALIAS = 'p';

    /**
     * Get answers with each poll
     * 
     * @var bool
     */
    protected $getAnswers = true;

    /**
     * {@inheritDoc}
     */
    protected function records(Collection $records): Collection 
    {
        return $records->map(function ($record) {
            // if (! empty($record->created_at)) {
            //     $record->created_at = Carbon::parse($record->created_at)->format('d-m-Y');
            // }

            // if (! empty($record->ends_at)) {
            //     $record->ends_at = Carbon::parse($record->ends_at)->format('d-m-Y');
            // }

            if (! empty($record->creatorImage)) {
                if (! filter_var($record->creatorImage, FILTER_VALIDATE_URL) && ! Str::startsWith($record->creatorImage, 'data:image')) {
                    $record->creatorImage = url($record->creatorImage);
                }
            }

            if ($this->getAnswers) {
                $record->answers = $this->answers->list([
                    'select' => ['answer', 'image', 'totalVotes'],
                    'poll_id' => $record->id,
                    'orderBy' => ['totalVotes', 'DESC'] 
                ]);
            }
            
            return $record;
        });
    }

    /**
     * {@inheritDoc}
     */
    protected function setData($poll, Request $request)
    {
        $poll->title = $request->title;

        if (! $poll->id) {
            $poll->status = 'voting';
        }

        $poll->type = $request->type;
        $poll->description = $request->description;
        $poll->requires_comment = $request->requires_comment == 'yes';
        $poll->allow_more_answers = (bool) $request->allow_more_answers;
        $poll->ends_at = Carbon::parse($request->ends_at);
    } 

    /**
     * {@inheritDoc}
     */
    protected function onSave($poll, Request $request)
    {
        $poll->answers()->delete();

        foreach ((array) $request->answers as $answer) {
            foreach ($answer as $key => $value) {
                $request->$key = $value;
            }

            $request->poll_id = $poll->id;

            $this->answers->create($request);

            $request->id = null;
        }
    }

    /**
     * Make new vote
     * 
     * @param  int $pollId
     * @param  \Request $request
     * @return void
     */
    public function vote(int $pollId, Request $request)
    {
        $pollVote = new PollVote;

        $pollVote->poll_id = $pollId;
        $pollVote->poll_answer_id = (int) $request->answer->id;
        $pollVote->poll_answer = (string) $request->answer->answer;
        $pollVote->poll_answer_image = (string) Str::removeFirst(url(''), $request->answer->image);
        $pollVote->comment = (string) $request->comment;
        $pollVote->save();
    }

    /**
     * {@inheritDoc}
     */
    public function get(int $id): \Item
    {
        $poll = Poll::find($id);
        
        $pollInfo = (object) $poll->getAttributes();

        $pollInfo->answers = $poll->answers->toArray();

        return new PollItem($pollInfo);
    }

    /**
     * Get poll with answers and full details
     * 
     * @param  int $id
     * @return mixed
     */
    public function getPollWithAnswers(int $id)
    {
        $poll = Poll::where('p.id', $id)
                    ->from('polls as p')
                    ->join('users as u', 'u.id', '=', 'p.created_by')
                    ->select('p.*', 'u.image as creatorImage')
                    ->selectRaw('CONCAT(u.first_name, " ", u.last_name) as creatorName')
                    ->first();


        if (! empty($poll->creatorImage)) {
            if (! filter_var($poll->creatorImage, FILTER_VALIDATE_URL) && ! Str::startsWith($pull->creatorImage, 'data:image')) {
                $poll->creatorImage = url($poll->creatorImage);
            }
        }
        
        $pollInfo = [];

        foreach (['id', 'title', 'type', 'status', 'voted', 'created_by', 'creatorName', 'creatorImage', 'description', 'created_at', 'ends_at', 'requires_comment', 'allow_more_answers'] as $column) {
            $pollInfo[$column] = $poll->$column;
        }

        // $pollInfo['created_at'] = Carbon::parse($poll->created_at)->format('d-m-Y');
        // $pollInfo['ends_at'] = Carbon::parse($poll->ends_at)->format('d-m-Y');
        // $pollInfo['created_at'] = (string) $poll->created_at;
        $pollInfo['ends_at'] = $poll->ends_at;
       
        $pollInfo['answers'] = $this->answers->list([
            'select' => ['totalVotes', 'answer', 'id', 'image', 'comment'],
            'poll_id' => $poll->id,
            'orderBy' => ['pa.id', 'ASC'],
        ]);

        $pollInfo['voted'] = (bool) PollVote::where('poll_id', $id)->where('created_by', user()->id)->first();

        return $pollInfo;
    }

    /**
     * {@inheritDoc}
     */
    protected function select()
    {
        foreach (['id', 'title', 'created_at', 'ends_at', 'status'] as $column) {
            $this->select->replace($column, $this->column($column));
        }

        if ($this->select->has('answers')) {
            $this->select->remove('answers');
            $this->getAnswers = true;
        }

        if ($this->select->has('voted')) {
            $this->select->replace('voted', $this->raw('(SELECT pv.id FROM poll_votes as pv WHERE p.id = pv.poll_id AND pv.created_by = ' . user()->id . ') as voted'));
        }

        if ($this->select->has('totalVotes')) {
            $this->select->replace('totalVotes', $this->raw('(SELECT COUNT(pv.id) FROM poll_votes as pv WHERE p.id = pv.poll_id) as totalVotes'));
        }
        
        if ($this->select->has('createdBy')) {
            $this->select->remove('createdBy');

            $this->join('users as u', 'u.id', '=', 'p.created_by');

            $this->select->add($this->raw('CONCAT(u.first_name, " ", u.last_name) as creatorName'), 'u.image as creatorImage');
        }
    } 
    
    /**
     * {@inheritDoc}
     */
    protected function filter() 
    {
    }  
}
