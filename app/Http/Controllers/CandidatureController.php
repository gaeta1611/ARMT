<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidature;
use App\Mission;
use App\ModeCandidature;
use App\Status;
use App\InformationCandidature;
use App\Candidat;
use App\Document;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;


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

        $title = 'Ajouter une candidature';
        if($id) {
            $candidat = Candidat::find($id);
            $title .= " à {$candidat->nom} {$candidat->prenom}";
        } elseif($missionId) {
            $prefix = Mission::find($missionId)->user()->get()->first()->initials;
            $title .= " à la mission $prefix$missionId";
        }
        $route = 'candidatures.store';
        $method = 'POST';

    
        //Récuperer les missions en cours
        $ongoingMissions = Mission::ongoingMissions();

        $liste=[null =>'Aucun'];
        foreach($ongoingMissions as $ongoingMission) {
            $prefix = Mission::find($ongoingMission->id)->user()->get()->first()->initials;
            $liste[$ongoingMission->id] = " $prefix{$ongoingMission->id} =>{$ongoingMission->client->nom_entreprise} - {$ongoingMission->fonction->fonction}";
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
        //Modification en Ajax à partir de l'index des candidats
        if(preg_match("/candidats$/",$request->headers->get('referer'))) {
            $validatorData = $request->validate([
                'mission_id'=>'required',
                'candidat_id'=>'required',
            ]);
                
            $modeCandidature = ModeCandidature::where('media','LIKE','%DB%adva%')->first();
            if($modeCandidature) {
                $candidature = new Candidature(Input::all());
                $candidature->created_at = now()->format('Y-m-d');
                $candidature->status_id = 1;//1=>ouvert, à prevalider
                $candidature->mode_candidature_id =  $modeCandidature->id;

                if($candidature->save()){
                    Session::put('success','La candidature a bien été enregistré');
                }
                else{
                    Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
                }
            } else {
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
            $missionId = Input::all('mission_id');

            if($candidature->save()){
                Session::put('success','La candidature a bien été enregistré');

                $candidatId = Input::get('candidat_id');

                //L'ajout de la candidature a été initié a partir d'une missions
                if(preg_match("/\?mission=\d$/",$request->headers->get('referer'))) {
                    return redirect()->route('missions.show',$missionId);
                }
                
                //L'ajout de la candidature a été initié a partir d'un candidt
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
        //Récuperer le candidat
        $candidature = Candidature::find($id);
        
        //Récuperer la mission
        $missionId = $candidature->mission_id;
        $prefix = $candidature->mission()->user->get()->first()->initials;

        $candidat = Candidat::find($candidature->candidat_id);
        $candidatId = $candidature->candidat_id;

        $title = 'Modifier la candidature';
        $title .= " de {$candidat->nom} {$candidat->prenom}";
        $route = ['candidatures.update',$id];
        $method = 'PUT';

    
        //Récuperer les missions en cours
        $ongoingMissions = Mission::ongoingMissions();

        $liste=[null =>'Aucun'];
        foreach($ongoingMissions as $ongoingMission) {
            $liste[$ongoingMission->id] = " $prefix{$ongoingMission->id} =>{$ongoingMission->client->nom_entreprise} - {$ongoingMission->fonction->fonction}";
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
            'candidature'=>$candidature,

        ]);
        
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
        $candidature = Candidature::find($id);
        $data = Input::post();

        //Traitement des requetes client ajax(cf api)
        if($request->ajax()) {
            try {
                if($candidature->update($data)) {
                    return response()->json(true);
                } else {
                    return response()->json([0=>false,"message"=>"Erreur ajax"]);
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                if(preg_match("/candidat_already_assigned_to_mission/", $ex->getMessage())){
                    Session::push('errors','Ce candidat a deja postulé pour cette mission');
                } elseif(preg_match("/candidat_already_applied_to_mission/", $ex->getMessage())){
                    Session::push('errors','Ce candidat correspond à cette mission');
                } else {
                    Session::push('errors','Une erreur s\'est produite lors de l\'enregistrement');
                }
            }         
        }

        //Traitement du formulaire update
        $validatorData = $request->validate([
            'mission_id'=>'nullable|numeric',
            'candidat_id'=>'required|numeric|min:1',
            'created_at'=>'required|date',
            'postule_mission_id'=>'nullable|numeric',
            'mode_candidature_id'=>'required|numeric',
            'status_id'=>'required|numeric',
            //'rapport_interview_id'=>'nullable|numeric',
        ],[
            'mission_id.numeric'=>'Le type du champ mission_id est incorrect',
            'candidat_id.required'=>'Veuillez spécifier le candidat',
            'candidat_id.min'=>'Valeur incorrecte pour le candidat',
            'created_at.required'=>'Veuillez spécifier la date de candidature',
            'created_at.date'=>'Le type du champ created_at est incorrecte',
            'postule_mission_id.numeric'=>'Le type du champ postule_mission_id est incorrect',
            'mode_candidature_id.required'=>'Veuillez spécifier le mode de candidature',
            'status_id.required'=>'Veuillez spécifier le status',
            //'rapport_interview_id.numeric'=>'Le type du champ rapport_interview_id est incorrecte',
        ]);

        //Mise a jour du document (rapport interview)
        //Récuperer le  nouveau rapport d'interview chargé dans le formulaire
        $file = $request->file('rapport_interview_id');
        
        if($file){

            //Déplacer le fichier dans le dossier de téléchargement public
            $filename = Storage::putFile('public/uploads/rapports',$file);

            //Récuperer le nouveau nom de fichier
            $filename = strrchr($filename,"/");
            
            //Récuperer l'url du dossier de téléchargement
            //à partir du fichier de config config/filesystems.php
            $url = '/uploads/rapports'.$filename;

            //Enregistrer le document dans la base de donnée
            $rapport = new Document ();
            $rapport->type = 'Rapport d\'interview';
            $rapport->url_document = $url;
            $rapport->filename = $file->getClientOriginalName();

            if($rapport->save()){
                $oldRapportId = $candidature->rapport_interview_id;
                $candidature->rapport_interview_id = $rapport->id;
                
                //Suppression de l'ancien rapport d'interview
                if($request->get('delete')) {
                    $oldRapport = Document::find($oldRapportId);
                    
                    if(!Storage::disk('public')->delete($oldRapport->url_document)){
                        Session::push('errors','L\ancien rapport d\'interview n\'a pas pu être supprimé du disque !');
                    } else {
                        if($oldRapport->delete()) {
                            Session::push('errors','L\ancien rapport d\'interview n\'a pas pu être supprimé de la DB !');
                        }
                    }
                }
            } else{
                Session::push('errors','Erreur lors de l\'enregristrement du document (rapport interview)!');
            }
        //Il n'y a pas de nouveau rapport d'interview => sauver OU supprimer ancien rapport interview
        } elseif(empty($file) && !empty($request->get('rapport_interview_id'))) {
            //Suppression de l'ancien rapport d'interview
            if($request->get('delete')) {
                $oldRapport = Document::find($request->get('rapport_interview_id'));

                if(!Storage::disk('public')->delete($oldRapport->url_document)){
                    Session::push('errors','L\ancien rapport d\'interview n\'a pas pu être supprimé du disque !');
                } else {
                    if(!$oldRapport->delete()) {
                        Session::push('errors','L\ancien rapport d\'interview n\'a pas pu être supprimé !');
                    }
                }

                $candidature->rapport_interview_id = null;
            } else {  //Sauver ancien rapport interview
                $candidature->rapport_interview_id = $request->get('rapport_interview_id');
            }
        //Aucun rapport interview pour cette candidature
        } else {
            $candidature->rapport_interview_id = null;
        }

        $data['rapport_interview_id'] = $candidature->rapport_interview_id;
        try {
            if($candidature->update($data)){
                Session::put('success','La candidature a bien été enregistré');
    
                return redirect()->route('candidats.show',[$candidature->candidat_id]);
            }
            else{
                Session::push('errors',"Une erreur s\'est produite lors de l\'enregristrement de la candidature $candidature->id!");
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            if(preg_match("/candidat_already_assigned_to_mission/", $ex->getMessage())){
                Session::push('errors','Ce candidat a deja postulé pour cette mission');
            } elseif(preg_match("/candidat_already_applied_to_mission/", $ex->getMessage())){
                Session::push('errors','Ce candidat correspond à cette mission');
            } else {
                Session::push('errors','Une erreur s\'est produite lors de l\'enregistrement');
            }
        }

        return redirect()->route('candidats.show',$candidature->candidat_id);
        
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

