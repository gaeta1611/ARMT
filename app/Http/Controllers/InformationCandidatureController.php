<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InformationCandidature;

class InformationCandidatureController extends Controller
{
    public function getAll() {
    
        $data = InformationCandidature::all()->toArray();
        
        return response()->json($data);
    }
}
