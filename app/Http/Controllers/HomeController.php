<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if($user && $user->authorizeRoles(['admin','employee'])) {
            return view('index');
        }

        return view('auth.login');
    }
}
