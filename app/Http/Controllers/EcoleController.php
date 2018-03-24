<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ecole;

class EcoleController extends Controller
{
    public function getAll() {
        
        $data = Ecole::all()->toArray();
            

        return response()->json($data);
    }

    public function findDiplome(Request $request) {

        $ecole = Ecole::where('code_ecole','=',$request->code_ecole)
        ->get()->first();

        if(!$ecole) {
            $ecole = new Ecole($request->all());

            if(!$ecole->save()) {
                return response()->json(false);
            }    
        } 

        return response()->json($ecole);
            
    }

    public function store(Request $request) {
        
        $ecole = Ecole::where('code_ecole','=',$request->code_ecole)
                ->get()->first();

        if(!$ecole) {
            $ecole = new Ecole($request->all());

            if(!$ecole->save()) {
                return response()->json(false);
            }    
        } 

        return response()->json($ecole);
    }

}
