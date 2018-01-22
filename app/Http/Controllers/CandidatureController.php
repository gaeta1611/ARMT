<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidature;
use App\Mission;
use App\ModeCandidature;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Ajouter candidature';
        $route = 'candidatures.store';
        $method = 'POST';

        //Récuperer les missions en cours
        $ongoingMissions = Mission::ongoingMissions();

        $liste=[0=>'Aucun'];
        foreach($ongoingMissions as $ongoingMission) {
            $liste[$ongoingMission->id] = " EC{$ongoingMission->id}&nbsp;";;
        }
        $ongoingMissions = $liste;

        //Récuperer les modes de candidatures (média)
        $listMedias = ModeCandidature::all();

        $liste=[0=>'Aucun'];
        foreach($listMedias as $media) {
            $liste[$media->id] = "{$media->type} {$media->mode}";;
        }
        $listMedias = $liste;
        
        return view('candidatures.create',[
                    'title' => $title,
                    'route' => $route,
                    'method' => $method,
                    'ongoingMissions'=>$ongoingMissions,
                    'listMedias'=>$listMedias,
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
        
            $candidature = new Candidature(Input::all());
            $candidature->date_candidature = now()->format('Y-m-d');
            $candidature->date_traitement = NULL;//TODO verifier l'utilité de ce champs
            $candidature->status_id = 1;//1=>ouvert, à prevalider
            $candidature->mode_candidature_id = 3;//3=> par chasse, base de donnée

            if($candidature->save()){
                Session::put('success','La candidature a bien été enregistré');
            }
            else{
                Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
            }

            return redirect()->route('candidats.index');

        } else {
            $validatorData = $request->validate([
                'mission_id'=>'required',
                'candidat_id'=>'required',
                'date_candidature'=>'nullable|date',
                'date_traitement'=>'nullable|date',
                'status_id'=>'required|numeric',
                'information_candidature_id'=>'required|numeric',
                'mode_reponse_id'=>'required|numeric',
                'date_reponse'=>'nullable|date',
                'date_F2F'=>'nullable|date',
                'date_rencontre_client'=>'nullable|date',
                'rapport_interview'=>'required|max:255',
                'mode_candidature_id'=>'required|numeric',
    
            ]/*,[
                'nom_entreprise.required'=>'Veuillez entrer le nom d\'une entreprise',
                'nom_entreprise.unique'=>'Ce nom d\'une entreprise existe déjà',
                'nom_entreprise.max'=>'Le nom de l\'entreprise ne peut pas dépasser 60 caractères',
    
                'personne_contact.max'=>'La personne de contact ne peut pas dépasser 100 caractères',
                'telephone.max'=>'Le numéro de téléphone ne peut pas dépasser 20 chiffres',
    
                'email.email'=>'Veuillez entrer un email valide',
                'email.unique'=>'Cet email existe déjà',
                'email.max'=>'L\email ne peut pas dépasser 100 caractères',
    
                'adresse.required'=>'Veuillez entrer une adresse',
                'adresse.max'=>'L\'adresse ne peut pas dépasser 255 caractères',
    
                'localite.required'=>'Veuillez entrer une localité',
                'localite.numeric'=>'Type de valeur incorrecte pour la localité',
    
                'tva.required'=>'Veuillez entrer un numéro de TVA',
                'tva.max'=>'Le numéro de TVA ne peut pas dépasser 15 caractères',
    
                'site.url'=>'Veuillez entrer une URL valide pour le site',
                'site.unique'=>'Ce site existe déjà',
                'site.max'=>'L\' URL du site ne peut pas dépasser 255 caractères',
    
                'linkedin.url'=>'Veuillez entrer une URL valide pour Linkedin',
                'linkedin.unique'=>'Ce Linkedin existe déjà',
                'linkedin;max'=>'L\' URL de Linkedin ne peut pas dépasser 255 caractères'
            ]*/);

            $candidature = new Candidature(Input::all());
            //$candidature->date_candidature = now()->format('Y-m-d');
            //$candidature->date_traitement = NULL;//TODO verifier l'utilité de ce champs

            if($candidature->save()){
                Session::put('success','La candidature a bien été enregistré');
            }
            else{
                Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
            }
            
            return redirect()->route('missions.show',$mission->client_id);
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

