<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModeReponse;

class ModeReponseController extends Controller
{
    public function getAll() {
    
        $data = ModeReponse::all()->toArray();
        
        return response()->json($data);
    }
}
