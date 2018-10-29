<?php
namespace App\Http\Resources\Challenges;

use App\Http\Resources\Tags\Tags;
use App\Http\Resources\Users\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Challenge extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'status' => $this->when($this->status, $this->status),
            'tags' => new Tags($this->tags),
            'participants' => [],
        ];
        
        foreach ($this->participants as $participant) {
            $data['participants'][] = new User($participant);
        }

        foreach ($this->rewards as $reward) {
            $data['rewards'][] = [
                'reward' => $reward->reward,
                'rank' => $reward->rank,
            ];
        }

        return $data;
    }
}
