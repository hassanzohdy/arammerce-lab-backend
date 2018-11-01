<?php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    /**
     * {@inheritDoc}
     */
    const CREATED_AT = null;

    /**
     * {@inheritDoc}
     */
    const UPDATED_AT = null;

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
    protected $table = 'user_reset_password';

    /**
     * Get new token for the current user
     * 
     * @return string 
     */
    public function newToken($user): string 
    {
        $resetPassword = new static;

        $resetPassword->user_id = $user->id;
        $resetPassword->token = sha1(mt_rand()) . sha1(mt_rand());
        $resetPassword->save(); 

        return $resetPassword->token;
    }
}
