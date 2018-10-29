<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];

        foreach (['id', 'first_name', 'last_name', 'user_name', 'birthdate', 'email', 'accessToken', 'image', 'job_title', 'job_title_level', 'country', 'city'] as $column) {
            if ($column == 'image' && $this->$column) {
                // as the user may set a base64 image
                if (!filter_var($this->$column, FILTER_VALIDATE_URL) && !Str::startsWith($this->$column, 'data:image')) {
                    $this->$column = url($this->$column);
                }
            } elseif ($column == 'birthdate') {
                $this->$column = date('d-m-Y', $this->$column);
            } elseif ($column == 'accessToken' && !$this->$column) {
                continue;
            }

            $data[$column] = $this->$column;
        }

        $data['name'] = $this->first_name . ' ' . $this->last_name;

        return $data;
    }
}
