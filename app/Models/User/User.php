<?php
namespace App\Models\User;

use ModelTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use ModelTrait;

    /**
     * Disable guarded fields
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * {@inheritDoc} 
    */
    public function accessTokens()
    {
        return $this->hasMany(UserAccessToken::class);
    }
}
