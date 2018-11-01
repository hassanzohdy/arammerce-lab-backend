<?php
namespace App\Http\Middleware\Api;

use Auth as BaseAuth;
use Closure;
use Illuminate\Http\Request;

class Auth 
{
    /**
     * Application key
     * 
     * @const string
     */
    const API_KEY = 'GFSD312FAOP63143GSOP792SA';

    /**
     * Routes that does not have permissions
     */
    protected $ignoredRoutes = ["/api/login", "/api/register", '/api/login/forget-password'];

    /**
     * {@inheritDoc}
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->uri(), $this->ignoredRoutes)) {
            if ($request->authorizationValue() !== static::API_KEY) {
                return response('Invalid Request', 400);
            }

            return $next($request);
        } else {
            $accessToken = $request->authorizationValue();
            
            $user = repo('users')->getByAccessToken($accessToken);

            if ($user) {
                BaseAuth::login($user);

                return $next($request);
            } else {
                return response('Invalid Request', 400);
            }
        }
    }
}
