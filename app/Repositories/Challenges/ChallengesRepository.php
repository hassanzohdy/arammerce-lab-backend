<?php
namespace App\Repositories\Challenges;

use DB;
use Item;
use Request;
use Collection;
use RepositoryManager;
use App\Models\Challenge\Challenge;
use App\Models\Challenge\Participant;
use HZ\Laravel\Organizer\App\Contracts\RepositoryInterface;
use App\Http\Resources\Challenges\Challenge as ChallengeResource;

class ChallengesRepository extends RepositoryManager implements RepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    const MODEL = Challenge::class;

    /**
     * {@inheritDoc}
     */
    const TABLE = 'challenges';

    /**
     * {@inheritDoc}
     */
    const TABLE_ALIAS = 'c';

    /**
     * {@inheritDoc}
     */
    const DATA = ['title', 'starts_at', 'ends_at', 'status', 'description'];
    
    /**
     * Return tags with challenges
     * 
     * @var bool
     */
    protected $withTags = false;

    /**
     * Return Rewards with challenges
     * 
     * @var bool
     */
    protected $withRewards = false;

    /**
     * {@inheritDoc}
     */
    protected function records(Collection $records): Collection
    {
        return $records->map(function ($challenge) {
            if ($this->withTags) {
                $tags = DB::table('tags as t')->join('challenge_tags as ct', 't.id', 'ct.tag_id')->where('ct.challenge_id', $challenge->id)->get(['name', 'image']);

                $challenge->tags = $tags->map(function ($tag) {
                    $tag->image = url($tag->image);

                    return $tag;
                });
            }

            if ($this->withRewards) {
                $challenge->rewards = DB::table('challenge_rewards')->where('challenge_id', $challenge->id)->get(['reward', 'rank']);
            }

            
            return $challenge;
        });
    }

    /**
     * {@inheritDoc}
     */
    protected function setData($post, Request $request){}

    /**
     * {@inheritDoc}
     */
    protected function onSave($challenge, $request)
    {
        $challenge->rewards()->delete();
        $challenge->tags()->sync($request->tags);

        foreach ((array) $request->rewards as $reward) {
            $record = [
                'challenge_id' => $challenge->id,
                'reward' => $reward['reward'],
                'rank' => $reward['rank'],
            ];

            if (!empty($reward['id'])) {
                $record['id'] = $reward['id'];
            }

            DB::table('challenge_rewards')->insert($record);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function get(int $id)
    {
        return new ChallengeResource(Challenge::with('tags', 'rewards', 'participants')->find($id));
    }

    /**
     * Participate in the challenge
     * 
     * @param  int $challengeId
     * @param  int $userId
     * @return void
     */
    public function participate(int $challengeId, int $userId)
    {
        $participant = new Participant;

        $participant->challenge_id = $challengeId;
        $participant->user_id = $userId;
        
        $participant->save();
    }

    /**
     * {@inheritDoc}
     */
    protected function select()
    {
        foreach (['id', 'title', 'starts_at', 'ends_at', 'status'] as $column) {
            $this->select->replace($column, $this->column($column));
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function filter()
    {
        if ($status = $this->option('status')) {
            $this->where($this->column('status'), $status);
        }

        if ($this->select->has('tags')) {
            $this->withTags = true;
            $this->select->remove('tags');
        }

        if ($this->select->has('rewards')) {
            $this->withRewards = true;
            $this->select->remove('rewards');
        }
    }
}
