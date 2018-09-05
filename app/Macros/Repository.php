<?php
namespace App\Macros;

class Repository 
{
    /**
     * Join the users table to get the creator name and image 
     *
     * @return void
     */
    public function creator()
    {
        return function () {
            $this->select->remove('createdBy');

            $this->join('users as u', 'u.id', '=', $this->column('created_by'));

            $this->select->add($this->raw('CONCAT(u.first_name, " ", u.last_name) as creatorName'), 'u.image as creatorImage');
        };
    }
}
