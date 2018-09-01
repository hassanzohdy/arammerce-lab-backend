<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(\Request $request)
    {
        $user = \App\Models\User\User::find(1);

        $user->id = 1;

        $user->first_name = 'HH';

        $user->save();
    }
}
