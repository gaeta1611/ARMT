<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Interview;

class InterviewController extends Controller
{

    /**
     * Update or insert the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idCandidature
     * @return \Illuminate\Http\Response
     */
    public function updateStoreFor(Request $request, $idCandidature)
    {   
        $data = Input::post();
        $data['candidature_id'] = $idCandidature;

        if(!empty($data['where'])) {
            $whereField = explode('=',$data['where']);

            if(sizeof($whereField)>=2) { 
                $whereValue = $whereField[1];
                $whereField = $whereField[0];

                $data['type'] = $whereValue;
                unset($data['where']);
            } else {
                return response()->json([0=>false,"message"=>__('general.format_incorrect')]); 
            }
        } else {
            return response()->json([0=>false,"message"=>__('general.miss_type_interview')]); 
        }

        $interview = Interview::where([
            'candidature_id'=> $idCandidature, 
            $whereField => $whereValue,
        ]);

        if(empty($data['date_interview']) && $interview->delete()) {
            return response()->json(true);
        } elseif($interview->updateOrCreate($data)) {
            return response()->json(true);
        } else {
            return response()->json([0=>false,"message"=>"Error Ajax"]);
        }
        
    }

}
