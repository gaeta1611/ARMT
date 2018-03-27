<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Societe;

class SocieteController extends Controller
{
    public function getAll() {
        
        $data = Societe::all()->toArray();
            

        return response()->json($data);
    }

    public function store(Request $request) {
        
        $societe = Societe::where('nom_entreprise','=',$request->nom_entreprise)
                ->get()->first();

        if(!$societe) {
            $societe = new societe($request->all());

            if(!$societe->save()) {
                return response()->json(false);
            }    
        } 

        return response()->json($societe);
    }

}
