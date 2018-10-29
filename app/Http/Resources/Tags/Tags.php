<?php

namespace App\Http\Resources\Tags;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Tags extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($tag) {
            $tag->image = url($tag->image);
            
            return [
                'image' => $tag->image,
                'name' => $tag->name,
            ];
        });
    }
}
