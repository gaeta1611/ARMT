<?php

namespace App\Http\Controllers;
use App\Localite;

use Illuminate\Http\Request;

class LocaliteController extends Controller
{
    public function getLocaliteFromCP($cp) {
    
        $data = Localite::where(['code_postal'=>$cp])->get()->toArray();
        
        return response()->json($data);
    }

    public function getCPFromLocalite($localite) {
        
        $data = Localite::where(['localite'=>$localite])->get()->toArray();
            
        return response()->json($data);
    }
}
