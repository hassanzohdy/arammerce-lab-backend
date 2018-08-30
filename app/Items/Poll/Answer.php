<?php
namespace App\Items\Poll;

use Item;

class Answer extends Item
{
    /**
     * {@inheritDoc}
     */
    public function send(): array 
    {
        $data = [];

        foreach (['id', 'answer', 'comment', 'image'] as $column) {
            if ($this->$column) {
                if ($column == 'image' && $this->$column) {
                    $this->$column = url($this->image);
                }

                $data[$column] = $this->$column;
            }
        }



        if (isset($this->totalVotes)) {
            $data['totalVotes'] = $this->totalVotes;
        }

        return $data;
    }
}
