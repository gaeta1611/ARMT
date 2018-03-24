<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diplome;

class DiplomeController extends Controller
{
    public function getAll() {
        
        $data = Diplome::all()->toArray();
            

        return response()->json($data);
    }

    public function findDiplome(Request $request) {

        $diplome = Diplome::where('designation','=',$request->designation)
                ->where('finalite','=',$request->finalite)
                ->where('niveau','=',$request->niveau)
                ->get()->first();

        if($diplome) {
            return response()->json($diplome);
        } 
        return response()->json(false);
    
    }

    public function store(Request $request) {

        $diplome = Diplome::where('code_diplome','=',$request->code_diplome)
                ->where('designation','=',$request->designation)
                ->where('finalite','=',$request->finalite)
                ->where('niveau','=',$request->niveau)
                ->get()->first();

        if(!$diplome) {
            $diplome = new Diplome($request->all());

            if(!$diplome->save()) {
                return response()->json(false);
            }    
        } 

        return response()->json($diplome);
    }

}
