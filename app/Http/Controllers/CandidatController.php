<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidat;
use App\Localite;
use App\Mission;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Récuperer les données
        $candidats = Candidat::all();

        //Récuperer les missions en cours
        $ongoingMissions = Mission::where(['status'=>'En cours'])->get();

        $liste=[0=>''];
        foreach($ongoingMissions as $ongoingMission) {
            $liste[$ongoingMission->id] = " EC{$ongoingMission->id}&nbsp;";;
        }
        $ongoingMissions = $liste;

        //Envoyer les données à la vue ou rediriger
        return view ('candidats.index',[
            'candidats'=>$candidats,
            'ongoingMissions'=>$ongoingMissions,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Ajouter candidat';
        $route = 'candidats.store';
        $method = 'POST';
        
        return view('candidats.create',[
                    'title' => $title,
                    'route' => $route,
                    'method' => $method
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
        $validatorData = $request->validate([
            'nom'=> 'required|max:60',
            'prenom'=> 'required|max:60',
            'sexe'=>'required|max:1',
            'email'=>'email|required|unique:candidat|max:120',
            'localite'=>'required|numeric',
            //'date_naissance'=>'nullable|numeric',
            'telephone'=>'max:20',
            'linkedin'=>'nullable|url|unique:candidat|max:255',
        ],[
            'nom.required'=>'Veuillez entrer le nom du candidat',
            'nom.max'=>'Le nom du candidat ne peut pas dépasser 60 caractères',

            'prenom.required'=>'Veuillez entrer le prénom du candidat',
            'prenom.max'=>'Le prénom du candidat ne peut pas dépasser 60 caractères',

            'sexe.required'=>'Veuillez entrer le sexe du candidat',
            'sexe.max'=>'Veuillez renseigner m ou f pour le sexe du candidat',

            'email.required'=>'Veuillez entrer une email',
            'email.unique'=>'L\'adresse mail existe déjà',
            'email.max'=>'L\'email ne peut pas dépasser 120 caractères',

            'localite.required'=>'Veuillez entrer une localité',
            'localite.numeric'=>'Type de valeur incorrecte pour la localité',

            //'date_naissance.numeric'=>'Type de valeur incorrecte pour la date de naissance',

            'telephone.max'=>'Le numéro de téléphone ne peut pas dépasser 20 caractères',

            'linkedin.url'=>'Veuillez entrer une URL valide pour Linkedin',
            'linkedin.unique'=>'Ce Linkedin existe déjà',
            'linkedin;max'=>'L\' URL de Linkedin ne peut pas dépasser 255 caractères'
        ]);

        $candidat = new candidat(Input::all());
        if($candidat->save()){
            Session::put('success','Le candidat a bien été enregistré');
        }
        else{
            Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
        }

        return redirect()->route('candidats.index');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidat = Candidat::find($id);
        $title = 'Candidat : '.($candidat->nom).' '.($candidat->prenom);

        //TODO réglé relation many to one
        $localite = Localite::find($candidat->localite);


        return view('candidats.show',[
            'candidat'=>$candidat,
            'title' =>$title,
            'candidat_localite' =>$localite,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $candidat = Candidat::find($id);
        $title = 'Modifier candidat';
        $route = ['candidats.update',$id];
        $method = 'PUT';

        return view('candidats.create',[
            'candidat'=> $candidat,
            'title' => $title,
            'route' => $route,
            'method' => $method
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
        $validatorData = $request->validate([
            'nom'=> [
                'required',
                Rule::unique('candidat')->ignore($id),
                'max:60'
            ],
            'prenom'=> 'max:60',
            'telephone'=>'max:20',
            'email'=>[
                'email',
                Rule::unique('candidat')->ignore($id),
                'max:120'
            ],
            'localite'=>'required|numeric',
            'sexe'=>'required|max:1',
            'linkedin'=>[
                'nullable',
                'url',
                Rule::unique('candidat')->ignore($id),
                'max:60'
            ]
            //date de naissance

        ],[
            'nom.required'=>'Veuillez entrer le nom du candidat',
            'nom.max'=>'Le nom du candidat ne peut pas dépasser 60 caractères',

            'prenom.required'=>'Veuillez entrer le prénom du candidat',
            'prenom.max'=>'Le prénom du candidat ne peut pas dépasser 60 caractères',

            'sexe.required'=>'Veuillez entrer le sexe du candidat',
            'sexe.max'=>'Veuillez renseigner m ou f pour le sexe du candidat',

            'email.required'=>'Veuillez entrer une email',
            'email.unique'=>'L\'adresse mail existe déjà',
            'email.max'=>'L\'email ne peut pas dépasser 120 caractères',

            'localite.required'=>'Veuillez entrer une localité',
            'localite.numeric'=>'Type de valeur incorrecte pour la localité',

            'date_naissance.numeric'=>'Type de valeur incorrecte pour la date de naissance',

            'telephone.max'=>'Le numéro de téléphone ne peut pas dépasser 20 caractères',

            'linkedin.url'=>'Veuillez entrer une URL valide pour Linkedin',
            'linkedin.unique'=>'Ce Linkedin existe déjà',
            'linkedin;max'=>'L\' URL de Linkedin ne peut pas dépasser 255 caractères'
        ]);

        $candidat = Candidat::find($id);
        $data = Input::all();
       
        if($candidat->update($data)){
            Session::put('success','Le candidat a bien été enregistré');
        }
        else{
            Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
        }

        return redirect()->route('candidats.show',$id);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidat = Candidat::find($id);

        try {
            if(isset($candidat) && $candidat->delete()){
                Session::put('success','Le candidat a bien été supprimé');
            }else {
                Session::push('errors','Une erreur s\'est produite lors de la suppression du candidat!');
            }

        } catch (\Exception $ex){
                Session::push('errors','Impossible de supprimer ce candidat');
        }

        return redirect()->route('candidats.index');
    }
}
