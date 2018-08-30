<?php
namespace App\Items\Poll;

use Item;

class Poll extends Item
{
    /**
     * {@inheritDoc}
     */
    public function send(): array 
    {
        $data = [];

        foreach (['id', 'title', 'type', 'description', 'created_by', 'ends_at', 'requires_comment', 'allow_more_answers'] as $column) {
            $data[$column] = $this->$column;
        }

        $data['answers'] = [];

        foreach ($this->answers as $answer) {
            $data['answers'][] = [
                'id' => $answer['id'],
                'answer' => $answer['answer'],
                'comment' => $answer['comment'],
                'image' => $answer['image'] ? url($answer['image']) : '',
            ];
        }

        return $data;
    }
}
