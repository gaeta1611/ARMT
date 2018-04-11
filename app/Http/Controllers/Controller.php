<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $this->middleware('auth');

        $this->middleware(function($request, $next) {
            if(!session()->has('lang')) {
                session()->put('lang',auth()->user()->language);
            }

            App::setLocale(session('lang','en'));

            return $next($request);
        });
    }
}
