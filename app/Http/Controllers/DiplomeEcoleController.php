<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DiplomeEcole;

class DiplomeEcoleController extends Controller
{
    public function getAll() {
        
        $data = DiplomeEcole::all()->toArray();
            

        return response()->json($data);
    }

    public function findDiplome(Request $request) {

        $diplomeEcole = diplomeEcole::where('diplome_id','=',$request->diplome_id)
        ->where('ecole_id','=',$request->ecole_id)
        ->get()->first();

        if(!$diplomeEcole) {
            $diplomeEcole = new DiplomeEcole($request->all());

            if(!$diplomeEcole->save()) {
                return response()->json(false);
            }    
        } 

        return response()->json($diplomeEcole);
            
    }

}
