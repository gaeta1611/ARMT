<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Candidat;
use App\Localite;
use App\Mission;
use App\Langue;
use App\Diplome;
use App\Ecole;
use App\Societe;
use App\Fonction;
use App\CandidatSociete;
use App\CandidatLangue;
use App\CandidatDiplomeEcole;
use App\DiplomeEcole;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
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
        $ongoingMissions = Mission::ongoingMissions();
        $prefix = Config::get('constants.options.PREFIX_MISSION');

        $liste=[0=>''];
        foreach($ongoingMissions as $ongoingMission) {
            $liste[$ongoingMission->id] = " $prefix{$ongoingMission->id}&nbsp;";;
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
        
        $bestLangues = Langue::whereIn('designation',['francais','néerlendais','anglais'])->get();   //TODO get only 5 best
        $listeLangues = Langue::all();                 
        $listeLangues = $listeLangues->diff($bestLangues);
        
        $showLangues = $bestLangues;

        $autresLangues = [0=>''];
        foreach($listeLangues as $langue) {
            $autresLangues["{$langue->id}-{$langue->code_langue}"] = $langue->designation;
        }

        $diplomeEcoles = DiplomeEcole::with(['ecole','diplome'])->get();

        $designations = Diplome::select('designation')->distinct('designation')->get()->toArray();
        array_walk($designations, function(&$item) { $item= $item['designation']; });

        $finalites = Diplome::select('finalite')->distinct('finalite')->get()->toArray();
        array_walk($finalites, function(&$item) { $item= $item['finalite']; });

        $niveaux = Diplome::select('niveau')->distinct('niveau')->get()->toArray();
        array_walk($niveaux, function(&$item) { $item= $item['niveau']; });

        $ecoles = Ecole::all();

        $societes = Societe::all();
        $fonctions = Fonction::all();

        $actualSociety = '';
        $lastFunction = '';

        $societeCandidats = collect();

        $localites = Localite::all();
        
        return view('candidats.create',[
            'title' => $title,
            'route' => $route,
            'method' => $method,
            'showLangues' => $showLangues,
            'autresLangues' => $autresLangues,
            'diplomeEcoles' => $diplomeEcoles,
            'designations' => $designations,
            'finalites' => $finalites,
            'niveaux' => $niveaux,
            'ecoles' => $ecoles,
            'societes' => $societes,
            'fonctions' => $fonctions,
            'actualSociety' => $actualSociety,
            'lastFunction' => $lastFunction,
            'societeCandidats' => $societeCandidats,
            'localites'=> $localites
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
            'sexe'=>'required|max:1|in:m,f',
            'email'=>'email|required|unique:candidat|max:120',
            'localite_id'=>'numeric',
            'date_naissance'=>'nullable|date',
            'telephone'=>'max:20',
            'linkedin'=>'nullable|url|unique:candidat|max:255',
            'site'=>'nullable|url|unique:candidat|max:255',
        ],[
            'nom.required'=>'Veuillez entrer le nom du candidat',
            'nom.max'=>'Le nom du candidat ne peut pas dépasser 60 caractères',

            'prenom.required'=>'Veuillez entrer le prénom du candidat',
            'prenom.max'=>'Le prénom du candidat ne peut pas dépasser 60 caractères',

            'sexe.required'=>'Veuillez entrer le sexe du candidat',
            'sexe.max'=>'Veuillez renseigner m ou f pour le sexe du candidat',
            'sexe.in'=>'Veuillez renseigner m ou f pour le sexe du candidat',

            'email.required'=>'Veuillez entrer une email',
            'email.email'=>'Type de valeur incorrecte pour l\'email',
            'email.unique'=>'L\'adresse mail existe déjà',
            'email.max'=>'L\'email ne peut pas dépasser 120 caractères',

            'localite_id.numeric'=>'Type de valeur incorrecte pour la localité',

            'date_naissance.date'=>'Type de valeur incorrecte pour la date de naissance',

            'telephone.max'=>'Le numéro de téléphone ne peut pas dépasser 20 caractères',

            'linkedin.url'=>'Veuillez entrer une URL valide pour Linkedin',
            'linkedin.unique'=>'Ce Linkedin existe déjà',
            'linkedin.max'=>'L\' URL de Linkedin ne peut pas dépasser 255 caractères',

            'site.url'=>'Veuillez entrer une URL valide pour le site internet',
            'site.unique'=>'Ce site internet existe déjà',
            'site.max'=>'L\' URL du site  ne peut pas dépasser 255 caractères'
        ]);


        $candidat = new candidat(Input::all());
        if($candidat->save()){
            Session::put('success','Le candidat a bien été enregistré');

            $langues = Input::all('langue');
            if(isset($langues['langue'])) {
                foreach($langues['langue'] as $langueId => $langueNiveau) {
                    $candidatLangue = new CandidatLangue();
                    $candidatLangue->candidat_id = $candidat->id;
                    $candidatLangue->langue_id = substr($langueId,strrpos($langueId,'|')+1);
                    $candidatLangue->niveau = $langueNiveau;

                    if(!$candidatLangue->save()) {
                        Session::push('errors','Erreur lors de l\'enregristrement d\'une langue pour ce candidat!');
                    }

                }
            }

            $diplomes = Input::all('diplome_ecole_ids');
            if(isset($diplomes['diplome_ecole_ids']))  {
                foreach($diplomes['diplome_ecole_ids'] as $diplomeEcoleId) {
                    $candidatDiplomeEcole = new CandidatDiplomeEcole();
                    $candidatDiplomeEcole->candidat_id = $candidat->id;
                    $candidatDiplomeEcole->diplome_ecole_id = $diplomeEcoleId;

                    if(!$candidatDiplomeEcole->save()) {
                        Session::push('errors','Erreur lors de l\'enregristrement d\'un diplome pour ce candidat!');
                    }

                }
            }

            $societes = Input::all('socCan');
            if(isset($societes['socCan']) && isset($societes['socCan']['societeIds']))  {
                foreach($societes['socCan']['societeIds'] as $key => $societeId) {
                    $candidatSociete = new CandidatSociete();
                    $candidatSociete->candidat_id = $candidat->id;
                    $candidatSociete->societe_id = $societeId;
                    $candidatSociete->fonction_id = $societes['socCan']['fonctionIds'][$key];
                    $candidatSociete->date_debut = $societes['socCan']['dateDebuts'][$key];
                    $candidatSociete->date_fin = $societes['socCan']['dateFins'][$key];
                    $candidatSociete->societe_actuelle = $key==0 ? 1:0; // La premiere société

                    if(!$candidatSociete->save()) {
                        Session::push('errors','Erreur lors de l\'enregristrement de société pour ce candidat!');
                    }

                }
            }

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
        $localite = Localite::find($candidat->localite_id);


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
        
        $listeLangues = Langue::all();
        $bestLangues = Langue::whereIn('designation',['francais','néerlendais','anglais'])->get();      
        $candidatLangues = $candidat->langues()->get();
        
        if($candidatLangues->count()) {
            $showLangues = $bestLangues->merge($candidatLangues);
            $listeLangues = $listeLangues->diff($bestLangues)->diff($candidatLangues);
        } else {
            $showLangues= $bestLangues;
            $listeLangues = $listeLangues->diff($bestLangues);
        }

        $autresLangues = [0=>''];
        foreach($listeLangues as $langue) {
            $autresLangues["{$langue->id}-{$langue->code_langue}"] = $langue->designation;
        }
        
        $diplomeEcoles = DiplomeEcole::with(['ecole','diplome'])->get();

        $candidatDiplomeEcoles = CandidatDiplomeEcole::select('candidat_diplome_ecole.id as cde_id',
            'candidat_diplome_ecole.candidat_id as candidat_id',
            'candidat_diplome_ecole.diplome_ecole_id as de_id',
            'diplomes_ecoles.diplome_id as diplome_id',
            'diplomes_ecoles.ecole_id as ecole_id',
            'diplomes.code_diplome as code_diplome',
            'diplomes.designation as designation',
            'diplomes.finalite as finalite',
            'diplomes.niveau as niveau',
            'ecoles.code_ecole as code_ecole',
            'ecoles.nom as nom')
            ->join('diplomes_ecoles','candidat_diplome_ecole.diplome_ecole_id','=','diplomes_ecoles.id')
            ->join('diplomes','diplomes_ecoles.diplome_id','=','diplomes.id')
            ->leftJoin('ecoles','diplomes_ecoles.ecole_id','=','ecoles.id')
            ->where('candidat_id','=',$id)
            ->orderBy('designation')
            ->orderBy('niveau')
            ->get();

        $designations = Diplome::select('designation')->distinct('designation')->get()->toArray();
        array_walk($designations, function(&$item) { $item= $item['designation']; });

        $finalites = Diplome::select('finalite')->distinct('finalite')->get()->toArray();
        array_walk($finalites, function(&$item) { $item= $item['finalite']; });

        $niveaux = Diplome::select('niveau')->distinct('niveau')->get()->toArray();
        array_walk($niveaux, function(&$item) { $item= $item['niveau']; });

        $ecoles = Ecole::all();

        $societes = Societe::all();
        $fonctions = Fonction::all();

        $actualSociety = Societe::select('nom_entreprise')
                ->join('societe_candidat','societes.id','=','societe_candidat.societe_id')
                ->where('candidat_id','=',$id)
                ->where('societe_actuelle','=',1)->get();
            $actualSociety = isset($actualSociety->toArray()[0]['nom_entreprise']) ? 
                    $actualSociety->toArray()[0]['nom_entreprise']:'';
        
        
        $lastFunction = Fonction::select('fonction') 
                ->join('societe_candidat','fonctions.id','=','societe_candidat.fonction_id')
                ->where('candidat_id','=',$id)
                ->orderBy('societe_actuelle','DESC')
                ->orderBy('date_fin','DESC')
                ->get();
            $lastFunction = isset($lastFunction->toArray()[0]['fonction']) ? 
                    $lastFunction->toArray()[0]['fonction']:'';

        $societeCandidats = CandidatSociete::where('candidat_id','=',$id)
                ->orderBy('societe_actuelle','DESC')
                ->orderBy('date_fin','DESC')
                ->get();
        
        $localites = Localite::all();


        return view('candidats.create',[
            'candidat'=> $candidat,
            'title' => $title,
            'route' => $route,
            'method' => $method,
            'showLangues' => $showLangues,
            'autresLangues' => $autresLangues,
            'diplomeEcoles' => $diplomeEcoles,
            'candidatDiplomeEcoles' => $candidatDiplomeEcoles,
            'designations' => $designations,
            'finalites' => $finalites,
            'niveaux' => $niveaux,
            'ecoles' => $ecoles,
            'societes' => $societes,
            'fonctions' => $fonctions,
            'actualSociety' => $actualSociety,
            'lastFunction' => $lastFunction,
            'societeCandidats' => $societeCandidats,
            'localites' => $localites,
    
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
            'nom'=> 'required|max:60',
            'prenom'=> 'required|max:60',
            'sexe'=>'required|max:1|in:m,f',
            'email'=>[
                'email',
                Rule::unique('candidat')->ignore($id),
                'max:100'
            ],
            'localite_id'=>'numeric',
            'date_naissance'=>'nullable|date',
            'telephone'=>'max:20',
            'site'=>[
                'nullable',
                'url',
                Rule::unique('candidat')->ignore($id),
                'max:255'
            ],
            'linkedin'=>[
                'nullable',
                'url',
                Rule::unique('candidat')->ignore($id),
                'max:60'
            ]
        ],[
            'nom.required'=>'Veuillez entrer le nom du candidat',
            'nom.max'=>'Le nom du candidat ne peut pas dépasser 60 caractères',

            'prenom.required'=>'Veuillez entrer le prénom du candidat',
            'prenom.max'=>'Le prénom du candidat ne peut pas dépasser 60 caractères',

            'sexe.required'=>'Veuillez entrer le sexe du candidat',
            'sexe.max'=>'Veuillez renseigner m ou f pour le sexe du candidat',
            'sexe.in'=>'Veuillez renseigner m ou f pour le sexe du candidat',

            'email.required'=>'Veuillez entrer une email',
            'email.email'=>'Type de valeur incorrecte pour l\'email',
            'email.unique'=>'L\'adresse mail existe déjà',
            'email.max'=>'L\'email ne peut pas dépasser 120 caractères',

            'localite_id.numeric'=>'Type de valeur incorrecte pour la localité',

            'date_naissance.date'=>'Type de valeur incorrecte pour la date de naissance',

            'telephone.max'=>'Le numéro de téléphone ne peut pas dépasser 20 caractères',

            'linkedin.url'=>'Veuillez entrer une URL valide pour Linkedin',
            'linkedin.unique'=>'Ce Linkedin existe déjà',
            'linkedin.max'=>'L\' URL de Linkedin ne peut pas dépasser 255 caractères',

            'site.url'=>'Veuillez entrer une URL valide pour le site internet',
            'site.unique'=>'Ce site internet existe déjà',
            'site.max'=>'L\' URL du site  ne peut pas dépasser 255 caractères'
        ]);

        $candidat = Candidat::find($id);
        $data = Input::all();
       
        if($candidat->update($data)){
            Session::put('success','Le candidat a bien été enregistré');

            $langues = Input::all('langue');
            if(isset($langues['langue'])) {
                foreach($langues['langue'] as $langueId => $langueNiveau) {
                    $candidatLangue = CandidatLangue::updateOrCreate([ 
                        'candidat_id' => $id,
                        'langue_id' => substr($langueId,strrpos($langueId,'|')+1)
                    ], ['niveau' => $langueNiveau]);
                    
                    if(!$candidatLangue->id) {
                        Session::push('errors','Erreur lors de l\'enregristrement d\'une langue pour ce candidat!');
                    }

                }
            }
            
            //Gestion des diplomes
            //Récuperer de la DB les diplomes du candidat
            $cdes = CandidatDiplomeEcole::where('candidat_id','=',$id)->get()->toArray();
            $db_de_ids = [];
            foreach($cdes as $cde){
                $db_de_ids[] = $cde['diplome_ecole_id'];
            }
            //Récuperer du formulaire les diplomes mentionnées
            $diplomes = Input::all('diplome_ecole_ids');

            $form_de_ids = [];
            if(isset($diplomes['diplome_ecole_ids']))  {
                $form_de_ids = $diplomes['diplome_ecole_ids'];
            }
                
            //Déterminer les diplomes à ajouter dans la DB
            $addDiplomes = array_diff($form_de_ids,$db_de_ids);

            foreach($addDiplomes as $diplomeEcoleId) {
                $candidatDiplomeEcole = new CandidatDiplomeEcole();
                $candidatDiplomeEcole->candidat_id = $id;
                $candidatDiplomeEcole->diplome_ecole_id = $diplomeEcoleId;

                if(!$candidatDiplomeEcole->save()) {
                    Session::push('errors','Erreur lors de l\'enregristrement d\'un diplome pour ce candidat!');
                }

            }
            //Déterminer les diplomes à supprimer de la DB
            $deleteDiplomes = array_diff($db_de_ids,$form_de_ids);
            foreach($deleteDiplomes as $diplomeEcoleId) {
                $candidatDiplomeEcole = CandidatDiplomeEcole::where([
                    'candidat_id'=>$id,
                    'diplome_ecole_id'=>$diplomeEcoleId
                ])->first(); 
             
                if(!$candidatDiplomeEcole->delete()) {
                    Session::push('errors','Erreur lors de la suppression d\'un diplome pour ce candidat!');
                }

            }
            
            //Gestion des emplois antérieurs
            $data = Input::post();
        
            if(isset($data['socCan']) && !empty($data['socCan']['societeIds'])) {
                $cptNotSaved = 0;
                try {
                    for($i=0;$i<sizeof($data['socCan']['socCanIds']);$i++) {
                        $newCandidatSociete[] = CandidatSociete::updateOrCreate([
                            'id'=> $data['socCan']['socCanIds'][$i],
                        ],[
                            'candidat_id'=> $id,
                            'societe_id'=> $data['socCan']['societeIds'][$i],
                            'fonction_id'=> $data['socCan']['fonctionIds'][$i] ? $data['socCan']['fonctionIds'][$i]:null ,
                            'date_debut'=> $data['socCan']['dateDebuts'][$i] ? $data['socCan']['dateDebuts'][$i]:null,
                            'date_fin'=> $data['socCan']['dateFins'][$i] ? $data['socCan']['dateFins'][$i]:null,
                            'societe_actuelle'=>$i==0 ? 1:0,
                        ]);
                    } 
                } catch (\Exception $e) {
                    $cptNotSaved++;
                    $message = $e->getMessage();
                }
    
                if($cptNotSaved) {
                    Session::push('errors',"Une erreur s\'est produite lors de l\'enregristrement des emplois antérieus $cptNotSaved! $message");
                    
                }

                //Suppresion des emplois retirés
                $cptNotDeleted = 0;

                if(isset($data['socCan']['deletedIds'])){
                    foreach($data['socCan']['deletedIds'] as $deletedSocCanId) {
                        $deleteSocCan = CandidatSociete::where('id',$deletedSocCanId)
                            ->where('candidat_id',$id)
                            ->first();
                        if($deleteSocCan) {
                            try {
                                $deleteSocCan->delete();
                            } catch (\Exception $e) {
                                $cptNotDeleted++;
                                $message = $e->getMessage();
                            }
                        }                   
                    }
                    if($cptNotSaved) {
                        Session::push('errors',"Une erreur s\'est produite lors de l\'enregristrement des emplois antérieus $cptNotDeleted! $message");
                        
                    }
                }
            } 
        }
        else {
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
