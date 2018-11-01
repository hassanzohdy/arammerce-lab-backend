<?php
namespace App\Http\Controllers\Api\Auth;

use Mail;
use ApiController;
use App\Items\User\User;
use Auth;
use Request;
use Validator;
use App\Models\User\ResetPassword;

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
     * Send a reset password email
     * 
     * @param  \Request $request
     * @return string
     */
    public function forgetPassword(Request $request)
    {
        $email = $request->email;

        $user = $this->users->getBy('email', $email);

        if (! $user) {
            return $this->badRequest('Invalid email address');
        } 
    
        Mail::send([], [], function ($message) use ($user) {
            $resetPassword = new ResetPassword;
            $url = config('app.baseUrl') . '/reset-password/' . $resetPassword->newToken($user);
            $message->to($user->email)
              ->subject('Reset password')
              // or:
              ->setBody("
                <h1>Hello {$user->first_name}</h1>
                <a href=\"$url\">Click here to reset your damn password -_-</a>
                <h1>Do not forget your password again! :/</h1>
                <h1>If you forget your password many times, save it in some f***n place where you can get it -___-</h1>
              ", 'text/html'); // for HTML rich messages
          });

          return $this->success([]);
    }

    /**
     * Determine whether the passed values are valid
     *
     * @return mixed
     */
    private function scan(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    }
}
