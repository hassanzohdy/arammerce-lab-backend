<?php
namespace App\Http\Controllers\Api\Auth;

use Request;
use Validator;
use ApiController;
use App\Items\User\User;

class RegistrationController extends ApiController
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
            $user = $this->users->create($request);

            return $this->success([
                'user' => new User($user->getAttributes()),
            ]);
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
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:8',
            'image' => 'image',
        ]);

        $validator->after(function ($validator) use ($request) {
            // validate if the given image is valid image
            if ($request->image_url && ! @exif_imagetype($request->image_url)) {
                $validator->errors()->add('image_url', 'Invalid image url!');
            }

            if (! $request->image && ! $request->image_url) {
                $validator->errors()->add('image', 'Image is required!');
            }
        });

        return $validator;
    }
}
