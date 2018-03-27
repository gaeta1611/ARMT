<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fonction;

class FonctionController extends Controller
{
    public function getAll() {
        
        $data = Fonction::all()->toArray();
            

        return response()->json($data);
    }

    public function store(Request $request) {
        
        $fonction = Fonction::where('fonction','=',$request->fonction)
                ->get()->first();

        if(!$fonction) {
            $fonction = new Fonction($request->all());

            if(!$fonction->save()) {
                return response()->json(false);
            }    
        } 

        return response()->json($fonction);
    }

}
