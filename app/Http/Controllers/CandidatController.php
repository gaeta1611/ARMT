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
use App\Status;
use App\CandidatLangue;
use App\CandidatDiplomeEcole;
use App\DiplomeEcole;
use App\ModeCandidature;
use App\Candidature;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Carbon;


class CandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Récuperation des filtres
        $status = $request->query('status');
        $mode = $request->query('mode');
        $type = $request->query('type');

        //Récuperer les données
        $candidats = Candidat::distinct()->select('candidat.*');
        if($status) {
            $candidats = $candidats->join('candidature','candidat.id','candidature.candidat_id')
                    ->join('status','candidature.status_id','status.id')
                    ->where(['status.avancement' => $status])->get();
        } elseif($mode) {
            $candidats = $candidats->join('candidature','candidat.id','candidature.candidat_id')
                    ->join('mode_candidature','candidature.mode_candidature_id','mode_candidature.id')
                    ->where('mode_candidature.media','LIKE','%"mode":"%'.$mode.'%"%');
            if($type) {
                $candidats->where('mode_candidature.media','LIKE','%"type":"%'.$type.'"%');        
            }

            $candidats = $candidats->get();
        } else {
            $candidats = Candidat::all();         
        }
        
        
        //Récuperer les missions en cours
        $ongoingMissions = Mission::ongoingMissions();
        $prefix = Config::get('constants.options.PREFIX_MISSION');

        $liste=[0=>''];
        foreach($ongoingMissions as $ongoingMission) {
            $liste[$ongoingMission->id] = " $prefix{$ongoingMission->id}&nbsp;";;
        }
        $ongoingMissions = $liste;

        //Récuperer les données du formulaire de recherche
        $bestLangues = Langue::whereIn('designation',['francais','néerlendais','anglais'])->get();   //TODO get only 5 best
        $listeLangues = Langue::all();                 
        $listeLangues = $listeLangues->diff($bestLangues);
        
        $showLangues = $bestLangues;

        $autresLangues = [0=>'Autres'];
        foreach($listeLangues as $langue) {
            $autresLangues["{$langue->id}-{$langue->code_langue}"] = $langue->designation;
        }

        $designations = Diplome::select('designation')->distinct('designation')->get()->toArray();
        array_walk($designations, function(&$item) { $item= $item['designation']; });

        $finalites = Diplome::select('finalite')->distinct('finalite')->get()->toArray();
        array_walk($finalites, function(&$item) { $item= $item['finalite']; });

        $niveaux = Diplome::select('niveau')->distinct('niveau')->get()->toArray();
        array_walk($niveaux, function(&$item) { $item= $item['niveau']; });

        $ecoles = Ecole::all();

        $societes = Societe::all();
        $fonctions = Fonction::all();

        $avancements = Status::whereNotIn ('avancement', [
            'à traiter',
            'à contacter',
            'à valider'
        ])->get(['avancement']);

        $modeCandidatures = ModeCandidature::all();
        

        $counters["all"] = Candidat::all()->count();
        $counters["à traiter"] = Status::where(['avancement' => 'à traiter'])->first()->candidatures()->count();
        $counters["à contacter"] = Status::where(['avancement' => 'à contacter'])->first()->candidatures()->count();
        $counters["à valider"] = Status::where(['avancement' => 'à valider'])->first()->candidatures()->count();

        $counters["Stepstone"] = Candidature::join('mode_candidature','candidature.mode_candidature_id','mode_candidature.id')
                ->where('media','LIKE','%"mode":"Stepstone"%')->count();
        $counters["DB Stepstone"] = Candidature::join('mode_candidature','candidature.mode_candidature_id','mode_candidature.id')
                ->where('media','LIKE','{"type":"DB","mode":"Stepstone"}')->count();
        $counters["DB adva"] = Candidature::join('mode_candidature','candidature.mode_candidature_id','mode_candidature.id')
                ->where('media','LIKE','{"type":"DB","mode":"adva"}')->count();
                    

        //Envoyer les données à la vue ou rediriger
        return view ('candidats.index',[
            'candidats'=>$candidats,
            'ongoingMissions'=>$ongoingMissions,
            'showLangues' => $showLangues,
            'autresLangues' => $autresLangues,
            'designations'=>$designations,
            'finalites'=>$finalites,
            'niveaux'=>$niveaux,
            'ecoles'=>$ecoles,
            'societes'=>$societes,
            'fonctions'=>$fonctions,
            'counters' => $counters,
            'modeCandidatures' => $modeCandidatures,
            'avancements' =>$avancements,
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
        
        $bestLangues = Langue::whereIn('designation',['francais','néerlandais','anglais'])->get();   //TODO get only 5 best
        $listeLangues = Langue::all();                 
        $listeLangues = $listeLangues->diff($bestLangues);
        
        $showLangues = $bestLangues;

        $autresLangues = [0=>'Autres'];
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
            'localite_id' => 'nullable|numeric',
            'code_postal' => 'max:10',
            'localite' => 'max:120',
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

            'email.required'=>'Veuillez entrer un email',
            'email.email'=>'Type de valeur incorrecte pour l\'email',
            'email.unique'=>'L\'adresse mail existe déjà',
            'email.max'=>'L\'email ne peut pas dépasser 120 caractères',

            'localite_id.numeric' => 'Type de valeur incorrecte pour la localité!',
            //'code_postal.required' => 'Veuillez entrer un code postal.',
            'code_postal.max' => 'Le code postal ne peut dépasser 10 caractères.',
            //'localite.required' => 'Veuillez entrer une localité.',
            'localite.max' => 'La localité ne peut dépasser 120 caractères.',

            'date_naissance.date'=>'Type de valeur incorrecte pour la date de naissance',

            'telephone.max'=>'Le numéro de téléphone ne peut pas dépasser 20 caractères',

            'linkedin.url'=>'Veuillez entrer une URL valide pour Linkedin en ajoutant (http://)',
            'linkedin.unique'=>'Ce Linkedin existe déjà dans votre DBs',
            'linkedin.max'=>'L\' URL de Linkedin ne peut pas dépasser 255 caractères',

            'site.url'=>'Veuillez entrer une URL valide pour le site internet (http://)',
            'site.unique'=>'Ce site internet existe déjà dans votre DB',
            'site.max'=>'L\' URL du site  ne peut pas dépasser 255 caractères'
        ]);


        $candidat = new candidat(Input::all());
        $data = Input::all();

        //Ajout éventuel d'une nouvelle localité       
        if($data['localite_id']==null) {
            $localite = new Localite();
            $localite->code_postal = $data['code_postal'];
            $localite->localite = $data['localite'];
            
            if($localite->save()) {
                $candidat->localite_id = $localite->id;
                
                Session::put('success','Une nouvelle localité a été enregistrée.');
            } else {
                Session::push('errors','Une erreur s\'est produite lors de l\'enregistrement de la localité!');
                
                return redirect()->route('candidats.create');
            }
        }

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

            //Gestion des emplois antérieurs
            $data = Input::all('socCan');
            if(isset($data['socCan']) && !empty($data['socCan']['societeIds']))  {
                $cptNotSaved = 0;
                
                try {
                    for($i=0;$i<sizeof($data['socCan']['socCanIds']);$i++) {
                        //Cas d'une nouvelle société
                        $societeId = $data['socCan']['societeIds'][$i];

                        if($societeId!='' && !is_numeric($societeId)) {
                            $societe = Societe::where('nom_entreprise','=',$societeId)
                                ->get()->first();

                            $societeId = $societe->id;
                        }

                        //Cas d'une nouvelle société
                        $fonctionId = $data['socCan']['fonctionIds'][$i];
                        
                        if($fonctionId!='' && !is_numeric($fonctionId)) {
                            $fonction = Fonction::where('fonction','=',$fonctionId)
                                ->get()->first();

                            $fonctionId = $fonction->id;
                        }

                        $newCandidatSociete[] = CandidatSociete::updateOrCreate([
                            'id'=> $data['socCan']['socCanIds'][$i],
                        ],[
                            'candidat_id'=> $candidat->id,
                            'societe_id'=> $societeId,
                            'fonction_id'=> $fonctionId ? $fonctionId: null ,
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
            }

        }
        else{
            Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
        }

        return redirect()->route('candidatures.create.from.candidat',[$candidat->id]);
    
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

        $candidatDiplomeEcoles = CandidatDiplomeEcole::select('candidat_diplome_ecole.id as cde_id',
            'candidat_diplome_ecole.candidat_id as candidat_id',
            'candidat_diplome_ecole.diplome_ecole_id as de_id',
            'diplomes_ecoles.diplome_id as diplome_id',
            'diplomes_ecoles.ecole_id as ecole_id',
            'diplomes.code_diplome as code_diplome',
            'diplomes.designation as designation',
            'diplomes.finalite as finalite',
            'diplomes.niveau as niveau',
            'ecoles.code_ecole as code_ecole')
        ->join('diplomes_ecoles','candidat_diplome_ecole.diplome_ecole_id','=','diplomes_ecoles.id')
        ->join('diplomes','diplomes_ecoles.diplome_id','=','diplomes.id')
        ->leftJoin('ecoles','diplomes_ecoles.ecole_id','=','ecoles.id')
        ->where('candidat_id','=',$id)
        ->orderBy('designation')
        ->orderBy('niveau')
        ->get();

        $actualSociety = Societe::select('societes.id','nom_entreprise')
                ->join('societe_candidat','societes.id','=','societe_candidat.societe_id')
                ->where('candidat_id','=',$id)
                ->where('societe_actuelle','=',1)->get()->first();
    
    
        $lastFunction = Fonction::select('fonction', 'date_debut','date_fin') 
                ->join('societe_candidat','fonctions.id','=','societe_candidat.fonction_id')
                ->where('candidat_id','=',$id)
                ->orderBy('societe_actuelle','DESC')
                ->orderBy('date_fin','DESC')
                ->get()->first();
        

        $societeCandidats = CandidatSociete::where('candidat_id','=',$id)
            ->orderBy('societe_actuelle','DESC')
            ->orderBy('date_fin','DESC')
            ->get();

            if($societeCandidats->first() && $societeCandidats->first()->societe_id == $actualSociety->id) {
                $societeCandidats->shift();
            }

        return view('candidats.show',[
            'candidat'=>$candidat,
            'title' =>$title,
            'candidat_localite' =>$localite,
            'candidatDiplomeEcoles' => $candidatDiplomeEcoles,
            'societeCandidats' => $societeCandidats,
            'lastFunction' => $lastFunction,
            'actualSociety' => $actualSociety,
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
            'ecoles.code_ecole as code_ecole')
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
            'localite_id' => 'nullable|numeric',
            'code_postal' => 'max:10',
            'localite' => 'max:120',
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

            'localite_id.numeric' => 'Type de valeur incorrecte pour la localité!',
            //'code_postal.required' => 'Veuillez entrer un code postal.',
            'code_postal.max' => 'Le code postal ne peut dépasser 10 caractères.',
            //'localite.required' => 'Veuillez entrer une localité.',
            'localite.max' => 'La localité ne peut dépasser 120 caractères.',

            'date_naissance.date'=>'Type de valeur incorrecte pour la date de naissance',

            'telephone.max'=>'Le numéro de téléphone ne peut pas dépasser 20 caractères',

            'linkedin.url'=>'Veuillez entrer une URL valide pour Linkedin en ajoutant (http://)',
            'linkedin.unique'=>'Ce Linkedin existe déjà',
            'linkedin.max'=>'L\' URL de Linkedin ne peut pas dépasser 255 caractères',

            'site.url'=>'Veuillez entrer une URL valide pour le site internet (http://)',
            'site.unique'=>'Ce site internet existe déjà',
            'site.max'=>'L\' URL du site  ne peut pas dépasser 255 caractères'
        ]);

        $candidat = Candidat::find($id);
        $data = Input::all();

        //Ajout éventuel d'une nouvelle localité       
        if($data['localite_id']==null) {
            $localite = new Localite();
            $localite->code_postal = $data['code_postal'];
            $localite->localite = $data['localite'];
            
            if($localite->save()) {
                $data['localite_id'] = $localite->id;
                
                Session::put('success','Une nouvelle localité a été enregistrée.');
            } else {
                Session::push('errors','Une erreur s\'est produite lors de l\'enregistrement de la localité!');
                
                return redirect()->route('candidats.update');
            }
        }
       
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

                try { //Ajout d'emploi(avec association de nouvelle sociétés ou fonctions)
                    if(!empty($data['socCan']['socCanIds'])) {
                        for($i=0;$i<sizeof($data['socCan']['socCanIds']);$i++) {
                            //Cas d'une nouvelle société
                            $societeId = $data['socCan']['societeIds'][$i];

                            if($societeId!='' && !is_numeric($societeId)) {
                                $societe = Societe::where('nom_entreprise','=',$societeId)
                                    ->get()->first();

                                $societeId = $societe->id;
                            }

                            //Cas d'une nouvelle société
                            $fonctionId = $data['socCan']['fonctionIds'][$i];
                            
                            if($fonctionId!='' && !is_numeric($fonctionId)) {
                                $fonction = Fonction::where('fonction','=',$fonctionId)
                                    ->get()->first();

                                $fonctionId = $fonction->id;
                            }

                            $newCandidatSociete[] = CandidatSociete::updateOrCreate([
                                'id'=> $data['socCan']['socCanIds'][$i],
                            ],[
                                'candidat_id'=> $id,
                                'societe_id'=> $societeId,
                                'fonction_id'=> $fonctionId ? $fonctionId: null ,
                                'date_debut'=> $data['socCan']['dateDebuts'][$i] ? $data['socCan']['dateDebuts'][$i]:null,
                                'date_fin'=> $data['socCan']['dateFins'][$i] ? $data['socCan']['dateFins'][$i]:null,
                                'societe_actuelle'=>$i==0 ? 1:0,
                            ]);
                        }
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

     /**
     * Retrieve all the candidate that correspond to criteria in given form
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $inputs = Input::all();
        $ageMin = $inputs['age'];

        $candidats = Candidat::distinct()
            ->leftJoin('candidat_langues','candidat.id','candidat_langues.candidat_id')
            ->leftJoin('langues','candidat_langues.langue_id','langues.id')
            ->leftJoin('candidat_diplome_ecole','candidat.id','candidat_diplome_ecole.candidat_id')
            ->leftJoin('diplomes_ecoles','candidat_diplome_ecole.diplome_ecole_id','diplomes_ecoles.id')
            ->leftJoin('diplomes','diplomes_ecoles.diplome_id','diplomes.id')
            ->leftJoin('ecoles','diplomes_ecoles.ecole_id','ecoles.id')
            ->leftJoin('societe_candidat','candidat.id','societe_candidat.candidat_id')
            ->leftJoin('societes','societe_candidat.societe_id','societes.id')
            ->leftJoin('fonctions','societe_candidat.fonction_id','fonctions.id');

        if(!empty($inputs['age'])) {
            $dt = Carbon::now();
            $dt->year -= (int) $inputs['age'];

            $candidats->where('candidat.date_naissance','<=',$dt->toDateString());
        }

        if(!empty($inputs['langue'])) {
            $candidats->whereIn('candidat.id', function($query) use ($inputs) {
                $langueNiveau = current($inputs['langue']);
                $tLangue = explode('|',key($inputs['langue']));
                $codeLangue = $tLangue[0];
                $langueId = $tLangue[1];
                    
                $query->distinct()->select('candidat_langues.candidat_id as clc_id')
                    ->from('candidat_langues')
                    ->where([
                        ['candidat_langues.langue_id','=',$langueId],
                        ['candidat_langues.niveau','>=',$langueNiveau]
                    ]);

                    foreach(array_slice($inputs['langue'],1) as $codeId => $langueNiveau) {      
                        $tLangue = explode('|',$codeId);                                        
                        $codeLangue = $tLangue[0];
                        $langueId = $tLangue[1];
                    
                        $query->orWhere([
                            ['candidat_langues.langue_id','=',$langueId],
                            ['candidat_langues.niveau','>=',$langueNiveau]
                        ]);
                    }
                $query->groupBy('clc_id');
                $query->havingRaw('count(*) = '.count($inputs['langue']));
            });
            //dd($candidats->toSql());
        }

        if(!empty($inputs['designation'])) {
            $candidats->where('diplomes.designation','LIKE','%'.$inputs['designation'].'%');
        }

        if(!empty($inputs['finalite'])) {
            $candidats->where('diplomes.finalite','=',$inputs['finalite']);
        }

        if(!empty($inputs['niveau'])) {
            $candidats->where('diplomes.niveau','=',$inputs['niveau']);
        }

        if(!empty($inputs['code_ecole'])) {
            $candidats->where('ecoles.code_ecole','=',$inputs['code_ecole']);
        }

        if(!empty($inputs['societe'])) {
            $candidats->where('societes.nom_entreprise','=',$inputs['societe']);
        }

        if(!empty($inputs['fonction'])) {
            $candidats->where('fonctions.fonction','=',$inputs['fonction']);
        }

        $candidats = $candidats->get(['candidat.id','candidat.nom','candidat.prenom','candidat.date_naissance','candidat.created_at']);
        //echo'<pre>';print_r($candidats);echo'</pre>';
        
        //Récuperer les missions en cours
        $ongoingMissions = Mission::ongoingMissions();
        $prefix = Config::get('constants.options.PREFIX_MISSION');

        $liste=[0=>''];
        foreach($ongoingMissions as $ongoingMission) {
            $liste[$ongoingMission->id] = " $prefix{$ongoingMission->id}&nbsp;";;
        }
        $ongoingMissions = $liste;

        //Récuperer les données du formulaire de recherche
        $bestLangues = Langue::whereIn('designation',['francais','néerlendais','anglais']);  //TODO get only 5 best
        $extraLangues = $request->query('langue');
        if($extraLangues) {
            $langueIds = [];
            foreach($extraLangues as $langueId => $langueNiveau) {
                $tLangue = explode('|',$langueId);

                if(isset($tLangue[1])) {
                    $langueIds[] = $tLangue[1];      
                }
            }
            $bestLangues = $bestLangues->orWhereIn('langues.id',$langueIds);       
        }

        $bestLangues = $bestLangues->get();
        $listeLangues = Langue::all();                 
        $listeLangues = $listeLangues->diff($bestLangues);
        
        $showLangues = $bestLangues;

        $autresLangues = [0=>''];
        foreach($listeLangues as $langue) {
            $autresLangues["{$langue->id}-{$langue->code_langue}"] = $langue->designation;
        }

        $designations = Diplome::select('designation')->distinct('designation')->get()->toArray();
        array_walk($designations, function(&$item) { $item= $item['designation']; });

        $finalites = Diplome::select('finalite')->distinct('finalite')->get()->toArray();
        array_walk($finalites, function(&$item) { $item= $item['finalite']; });

        $niveaux = Diplome::select('niveau')->distinct('niveau')->get()->toArray();
        array_walk($niveaux, function(&$item) { $item= $item['niveau']; });

        $ecoles = Ecole::all();

        $societes = Societe::all();
        $fonctions = Fonction::all();

        $avancements = Status::whereNotIn ('avancement', [
            'à traiter',
            'à contacter',
            'à valider'
        ])->get(['avancement']);

        $modeCandidatures = ModeCandidature::all();
        
        $counters["all"] = Candidat::all()->count();
        $counters["à traiter"] = Status::where(['avancement' => 'à traiter'])->first()->candidatures()->count();
        $counters["à contacter"] = Status::where(['avancement' => 'à contacter'])->first()->candidatures()->count();
        $counters["à valider"] = Status::where(['avancement' => 'à valider'])->first()->candidatures()->count();

        $counters["Stepstone"] = Candidature::join('mode_candidature','candidature.mode_candidature_id','mode_candidature.id')
                ->where('media','LIKE','%"mode":"Stepstone"%')->count();
        $counters["DB Stepstone"] = Candidature::join('mode_candidature','candidature.mode_candidature_id','mode_candidature.id')
                ->where('media','LIKE','{"type":"DB","mode":"Stepstone"}')->count();
        $counters["DB adva"] = Candidature::join('mode_candidature','candidature.mode_candidature_id','mode_candidature.id')
                ->where('media','LIKE','{"type":"DB","mode":"adva"}')->count();
                    
        //Envoyer les données à la vue ou rediriger
        return view ('candidats.index',[
            'candidats'=>$candidats,
            'ongoingMissions'=>$ongoingMissions,
            'showLangues' => $showLangues,
            'autresLangues' => $autresLangues,
            'designations'=>$designations,
            'finalites'=>$finalites,
            'niveaux'=>$niveaux,
            'ecoles'=>$ecoles,
            'societes'=>$societes,
            'fonctions'=> $fonctions,
            'counters' => $counters,
            'avancements' =>$avancements,
            'modeCandidatures'=>$modeCandidatures
        ]);
    }

    /**
     * Retrieve all the candidate that correspond to criteria in given form
     *
     * @return \Illuminate\Http\Response
     */
    public function searchBy()
    {
    }
}
