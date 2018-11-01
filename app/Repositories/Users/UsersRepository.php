<?php

namespace App\Repositories\Users;

use Str;
use Request;
use Collection;
use RepositoryManager;
use App\Models\User\User;
use App\Models\User\UserAccessToken;
use App\Items\User\User as UserItem;
use HZ\Laravel\Organizer\App\Contracts\RepositoryInterface;

class UsersRepository extends RepositoryManager implements RepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    const MODEL = User::class;

    /**
     * {@inheritDoc}
     */
    const TABLE = 'users';
    
    /**
     * {@inheritDoc}
     */
    const TABLE_ALIAS = 'u';

    /**
     * {@inheritDoc}
     */
    protected function records(Collection $records): Collection
    {
        return $records->map(function ($record) {
            if (! empty($record->birthdate)) {
                $record->birthdate = date('d-m-Y', $record->birthdate);
            }
            
            return $record;
        });
    }

    /**
     * {@inheritDoc}
     */
    protected function setData($user, Request $request)
    {
        $user->city = $request->city;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->last_name = $request->last_name;
        $user->user_name = $request->user_name;
        $user->job_title = $request->job_title;
        $user->first_name = $request->first_name;
        $user->birthdate = strtotime($request->birthdate);
        $user->job_title_level = $request->job_title_level;

        if ($request->image) {
            // upload then store
            $user->image = $request->image->store('images');
        } elseif ($request->image_url) {
            $user->image = $request->image_url;
        }

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
    } 

    /**
     * {@inheritDoc}
     */
    protected function onCreate($user, Request $request)
    {
        $this->generateAccessToken($user, $request);
    }

    /**
     * Generate new access token to the given user model
     * 
     * @param  \App\Models\User\User $user
     * @param  |Illuminate\Http\Request $request
     * @return string
     */
    public function generateAccessToken(User $user, Request $request)
    {
        $userAccessToken = new UserAccessToken([
            'token' => Str::random(96),
        ]);

        $user->accessTokens()->save($userAccessToken);
        $user->accessToken = $userAccessToken->token;

        return $userAccessToken->token;
    }

    /**
     * Get user model by access token
     * 
     * @param  string $accessToken
     * @return \App\Models\User\User
     */
    public function getByAccessToken(string $accessToken): User
    {
        return UserAccessToken::where('token', $accessToken)->first()->user;
    }

    /**
     * {@inheritDoc}
     */
    public function get(int $id): UserItem
    {
        return new UserItem(User::find($id)->getAttributes());
    }

    /**
     * {@inheritDoc}
     */
    public function getBy(string $column, $value)
    {
        return User::where($column, $value)->first();
    }

    /**
     * {@inheritDoc}
     */
    protected function select()
    {
    } 
    
    /**
     * {@inheritDoc}
     */
    protected function filter() 
    {
        // filter by email
        if ($email= $this->option('email')) {
            $this->whereLike($this->column('email', $email));
        }
    }  
}
