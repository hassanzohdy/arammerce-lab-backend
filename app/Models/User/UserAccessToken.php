<?php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserAccessToken extends Model
{
    /**
     * Disable guarded fields
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Model table
     * 
     * @var string
     */
    protected $table = 'user_access_tokens';

    /**
     * {@inheritDoc}
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
