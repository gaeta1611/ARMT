<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidature;
use App\Mission;
use App\ModeCandidature;
use App\Status;
use App\Candidat;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;


class CandidatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id Identifiant du candidat
     * @return \Illuminate\Http\Response
     */
    public function create($id=NULL)
    {
        //Récuperer le candidat
        $candidatId = $id;
        
        //Récuperer la mission
        $missionId = Input::get('mission');
        $prefix = Config::get('constants.options.PREFIX_MISSION');

        $title = 'Ajouter une candidature';
        if($id) {
            $candidat = Candidat::find($id);
            $title .= " à {$candidat->nom} {$candidat->prenom}";
        } elseif($missionId) {
            $prefix = Config::get('constants.options.PREFIX_MISSION');
            $title .= " à la mission $prefix$missionId";
        }
        $route = 'candidatures.store';
        $method = 'POST';

    
        //Récuperer les missions en cours
        $ongoingMissions = Mission::ongoingMissions();

        $liste=[null =>'Aucun'];
        foreach($ongoingMissions as $ongoingMission) {
            $liste[$ongoingMission->id] = " $prefix{$ongoingMission->id}&nbsp;";;
        }
        $ongoingMissions = $liste;


        //Récuperer les modes de candidatures (média)
        $listMedias = ModeCandidature::all();

        $liste=[null =>'Aucun'];
        foreach($listMedias as $media) {
            $liste[$media->id] = "{$media->type} {$media->mode}";;
        }
        $listMedias = $liste;

        //Récuperer les status
        $listStatus = Status::all();
        
        $liste=[];
        foreach($listStatus as $status) {
            $liste[$status->status] [$status->id] = $status->avancement;
        }
        $listStatus = $liste;

        //Récuperer les modes de candidatures (média)
        $candidats = Candidat::orderBy('nom')->get();
        
        $liste=[null=>'Aucun'];
        foreach($candidats as $candidat) {
            $liste[$candidat->id] = "{$candidat->nom} {$candidat->prenom}";;
        }
        $candidats = $liste;
        
        return view('candidatures.create',[
                    'title' => $title,
                    'route' => $route,
                    'method' => $method,
                    'ongoingMissions'=>$ongoingMissions,
                    'listMedias'=>$listMedias,
                    'listStatus'=>$listStatus,
                    'candidats'=>$candidats,
                    'candidatId'=>$candidatId,
                    'missionId'=>$missionId,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(preg_match("/candidats$/",$request->headers->get('referer'))) {
            $validatorData = $request->validate([
                'mission_id'=>'required',
                'candidat_id'=>'required',
            ]);
                
            $modeCandidature_id = ModeCandidature::where('media','LIKE','%chasse%DB adva%')->first()->id;

            $candidature = new Candidature(Input::all());
            $candidature->created_at = now()->format('Y-m-d');
            $candidature->status_id = 1;//1=>ouvert, à prevalider
            $candidature->mode_candidature_id =  $modeCandidature_id;

            if($candidature->save()){
                Session::put('success','La candidature a bien été enregistré');
            }
            else{
                Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
            }

            return redirect()->route('candidats.index');

        } else {
            $validatorData = $request->validate([
                'mission_id'=>'nullable|numeric',
                'candidat_id'=>'required|numeric|min:1',
                'created_at'=>'required|date',
                'postule_mission_id'=>'nullable|numeric',
                'mode_candidature_id'=>'required|numeric',
                'status_id'=>'required|numeric',
                'mode_reponse_id'=>'nullable|numeric',
                'date_reponse'=>'nullable|date',
                'date_F2F'=>'nullable|date',
                'date_rencontre_client'=>'nullable|date',
                'rapport_interview_id'=>'nullable|numeric',
                
    
            ],[
                'mission_id.numeric'=>'Le type du champ mission_id est incorrect',
                'candidat_id.required'=>'Veuillez spécifier le candidat',
                'candidat_id.min'=>'Valeur incorrecte pour le candidat',
                'created_at.required'=>'Veuillez spécifier la date de candidature',
                'created_at.date'=>'Le type du champ created_at est incorrecte',
                'postule_mission_id.numeric'=>'Le type du champ postule_mission_id est incorrect',
                'mode_candidature_id.required'=>'Veuillez spécifier le mode de candidature',
                'status_id.required'=>'Veuillez spécifier le status',
                'mode_reponse_id.numeric'=>'Le type du champ mode_reponse_id est incorrecte',
                'date_reponse.date'=>'Le type du champ date_reponse est incorrecte',
                'date_F2F.date'=>'Le type du champ date_F2F est incorrecte',
                'date_rencontre_client.date'=>'Le type du champ date_rencontre_client est incorrecte',
                'rapport_interview_id.numeric'=>'Le type du champ rapport_interview_id est incorrecte',
            ]);

            $candidature = new Candidature(Input::all());

            if($candidature->save()){
                Session::put('success','La candidature a bien été enregistré');

                $candidatId = Input::get('candidat_id');

                return redirect()->route('candidats.show',$candidatId);
            }
            else{
                Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
            }
            
        }
        

        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
    }


}

