<?php
namespace App\Http\Controllers\Api\Auth;

use ApiController;
use App\Items\User\User;
use Auth;
use Request;
use Validator;

class LoginController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $validator = $this->scan($request);

        if ($validator->passes()) {
            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return $this->unauthorized('Invalid Data');
            } else {
                $user = user();
                $this->users->generateAccessToken($user, $request);

                return $this->success([
                    'user' => new User($user->getAttributes()),
                ]);
            }

        } else {
            return $this->badRequest($validator->errors());
        }
    }

    /**
     * Determine whether the passed values are valid
     *
     * @return mixed
     */
    private function scan(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:8',
        ]);
    }
}
