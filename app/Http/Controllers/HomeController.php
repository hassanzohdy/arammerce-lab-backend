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
        
        echo bcrypt('12345678');
    }
}
