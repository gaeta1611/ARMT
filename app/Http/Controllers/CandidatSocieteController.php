<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\CandidatSociete;

class CandidatSocieteController extends Controller
{

    /**
     * Update or insert the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idCandidat
     * @return \Illuminate\Http\Response
     */
    public function storeFor(Request $request, $idCandidat)
    {   
        $data = Input::post();

        if(isset($data['socCan']) && !empty($data['socCan']['societeIds'])) {
            $cptNotSaved = 0;
            try {
                for($i=0;$i<sizeof($data['socCan']['societeIds']);$i++) {
                    $newCandidatSociete = CandidatSociete::updateOrCreate([
                        'id'=> $data['socCan']['socCanIds'][$i],
                    ],[
                        'candidat_id'=> $id,
                        'societe_id'=> $data['socCan']['societeIds'][$i],
                        'fonction_id'=> $data['socCan']['fonctionIds'][$i] ? $data['socCan']['fonctionIds'][$i]:null ,
                        'date_debut'=> $data['socCan']['dateDebuts'][$i] ? $data['socCan']['dateDebuts'][$i]:null,
                        'date_fin'=> $data['socCan']['dateFins'][$i] ? $data['socCan']['dateFins'][$i]:null,
                        'societe_actuelle'=> $i==0 ? 1 : 0,
                    ]);
                }
            } catch (\Exception $e) {
                $cptNotsaved++;
                $message = $e->getMessage();
            }

            if($cptNotSaved===0) {
                return response()->json(true);
            } else {
                return response()->json([0=>false,"message"=>"Erreur Ajax: $cptNotSaved emploi non sauvés!"]);
            }
        
        } else {
            return response()->json([0=>false,"message"=>__('general.data_incomplete')]);       
        }       
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidatSociete = CandidatSociete::find($id);

        try {
            if(isset($candidatSociete) && $candidatSociete->delete()){
                return response()->json(true);
            }else {
                return response()->json([0=>false,"message"=>'errors',__('general.error_emploi_delete')]);
            }

        } catch (\Exception $ex){
            return response()->json([0=>false,"message"=>__('general.impossible_emploi_delete')]);
        }

        return redirect()->route('clients.index');
    }

}
