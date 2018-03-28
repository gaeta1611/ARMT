<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Mission;
use App\TypeContrat;
use App\Document;
use App\Fonction;
use App\CandidatDiplomeEcole;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        //Récuperer les données
        $missions = Mission::all();
        
        //Traiter les données
        
        //Envoyer les données à la vue ou rediriger
        return view ('missions.index')->with('missions',$missions);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( $id=null )
    {
        //Récuperer le client pour lequel on créer la mission
        $oldClient = Client::find($id);

        //Définir le titre de la page
        $title = 'Ajouter mission';
        //Définir les paramètres du formulaire
        $route = 'missions.store';
        $method = 'POST';
        
        //Récuperer la liste des clients pour le formulaire(select)
        $listeClients = Client::orderBy('nom_entreprise')->get();
        $clients=[];
        foreach($listeClients as $client){
            $clients[$client->id] = $client->nom_entreprise;
        }
        
        //Récuperer la liste des types de contrats pour le formulaire(select)
        $listTypesContrat = TypeContrat::all();
        $typesContrat = [];
        foreach($listTypesContrat as $type){
            $typesContrat[$type->id] = $type->type;
        }

        //Récuperer la liste des fonctions  pour le formulaire(datalist)
        $fonctions = Fonction::all();

        //Récuperer la liste des status pour le formulaire(select)
        $listStatus = DB::select(
            DB::raw("SHOW COLUMNS FROM mission WHERE FIELD = 'status'")
        )[0]->Type;
        preg_match('/^enum\((.*)\)$/', $listStatus, $matches);
        $listeStatus = [];
        foreach( explode(',', $matches[1]) as $value )
        {
          $v = trim( $value, "'" );
          $listeStatus = array_add($listeStatus, $v, $v);
        }

        return view('missions.create',[
                    'title' => $title,
                    'route' => $route,
                    'method' => $method,
                    'clients' =>$clients,
                    'oldClient' => $oldClient,
                    'typesContrat' => $typesContrat,
                    'listeStatus' => $listeStatus,
                    'fonctions' => $fonctions,

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
            'client_id'=> 'required',
            'fonction'=> 'required|max:80',
            'type_contrat_id'=>'required|numeric',
            'status'=>'required',
            //'contrat_id'=>'nullable',
            //'job_description_id'=>'nullable',
            
            
        ],[
            'client_id.required'=>'Veuillez entrer le nom du client',
            
            'fonction.required'=>'Veuillez entrer la fonction recherchée',
            'fonction.numeric'=>'La fonction ne peut dépasser 80 caractères',

            'type_contrat_id.required'=>'Veuillez entrer le type de contrat',
            'type_contrat_id.numeric'=>'Le type du contrat est incorrecte',

            'status.required'=>'Veuillez entrer le type de status'
        ]);

        $extraSuccessMsg = '';

        $mission = new Mission(Input::all());
        $data = Input::all('fonction');

        //Retrouver la fonction correspondante ou l'ajouter dans la table Fonctions
        $fonction = Fonction::where(['fonction'=>$data['fonction']])
                                ->firstOrCreate(['fonction'=>$data['fonction']]);
        if($fonction->wasRecentlyCreated) {
            $extraSuccessMsg = 'Une nouvelle fonction a bien été ajoutée.';
        }

        $mission->fonction_id = $fonction->id;
        
        //Récuperer le fichier chargé dans le formulaire
        $file = $request->file('contrat_id');
        
        if($file){

            //Déplacer le fichier dans le dossier de téléchargement public
            $filename = Storage::putFile('public/uploads/contrats',$file);

            //Récuperer le nouveau nom de fichier
            $filename = strrchr($filename,"/");
            
            //Récuperer l'url du dossier de téléchargement
            //à partir du fichier de config config/filesystems.php
            $url = '/uploads/contrats'.$filename;

            //Enregistrer le document dans la base de donnée
            $contrat = new Document ();
            $contrat->type = 'Contrat';
            $contrat->url_document = $url;
            $contrat->filename = $file->getClientOriginalName();

            if(!$contrat->save()){
                Session::push('errors','Erreur lors de l\'enregristrement du document (contrat)!');
            }
        }
        
        $mission->contrat_id = $file ? $contrat->id:null;
        
        if($mission->save()){
            Session::put('success','La mission a bien été enregistrée'.'<br \>'.$extraSuccessMsg);
            
        //Déplacer le job description dans le dossier uploads
        $jobFiles = $request->file('job_description_ids');
        
            if($jobFiles){
                for($i=0;$i<count($jobFiles);$i++){
        
                    //Déplacer le fichier dans le dossier de téléchargement public
                    $filename = Storage::putFile('public/uploads/jobs',$jobFiles[$i]);
        
                    //Récuperer le nouveau nom de fichier
                    $filename = strrchr($filename,"/");
        
                    //Récuperer l'url du dossier de téléchargement
                    //à partir du fichier de config config/filesystems.php
                    $url = '/uploads/jobs'.$filename;
        
                    //Enregistrer le document dans la base de donnée
                    $job_desc = new Document ();
                    $job_desc-> type ='Job description';
                    $job_desc-> description = $request->input('descriptionsForJob') [$i];
                    $job_desc->url_document = $url;
                    $job_desc->filename = $jobFiles[$i]->getClientOriginalName();
                    $job_desc->mission_id = $mission->id;
        
                    if(!$job_desc->save()){
                        Session::push('errors','Erreur lors de l\'enregristrement du document (job description)!');
                    }
                }
            }

            //Déplacer l'offre dans le dossier uploads
            $offreFiles = $request->file('offre_ids');
            
                if($offreFiles){
                    for($i=0;$i<count($offreFiles);$i++){
            
                        //Déplacer le fichier dans le dossier de téléchargement public
                        $filename = Storage::putFile('public/uploads/offres',$offreFiles[$i]);
            
                        //Récuperer le nouveau nom de fichier
                        $filename = strrchr($filename,"/");
            
                        //Récuperer l'url du dossier de téléchargement
                        //à partir du fichier de config config/filesystems.php
                        $url = '/uploads/offres'.$filename;
            
                        //Enregistrer le document dans la base de donnée
                        $offre = new Document ();
                        $offre-> type ='Offre';
                        $offre-> description = $request->input('descriptionsForOffre') [$i];
                        $offre->url_document = $url;
                        $offre->filename = $offreFiles[$i]->getClientOriginalName();
                        $offre->mission_id = $mission->id;
            
                        if(!$offre->save()){
                            Session::push('errors','Erreur lors de l\'enregristrement du document (offre)!');
                        }
                    }
                }
        } else {
            Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
        }

        return redirect()->route('clients.show',$mission->client_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $mission = Mission::find($id);
        $client = Client::find($mission->client_id);
        $title = 'Mission : ' .Config('constants.options.PREFIX_MISSION').($mission->id);

        foreach($mission->candidatures as $candidature) {
            $candidature->F2F = null;
            $candidature->rencontreClient = null;
            $candidature->rencontre3 = null;
            foreach($candidature->interviews as $interview)
                switch($interview->type){
                    case 'F2F':
                        $candidature->F2F = $interview->date_interview;break;
                    case 'rencontre client':
                        $candidature->rencontreClient  = $interview->date_interview;break;
                    case '3e rencontre':
                        $candidature->rencontre3  = $interview->date_interview;break;

            }
        }


        return view('missions.show',[
            'mission'=>$mission,
            'client'=>$client,
            'title' =>$title,
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
        
        //Récuper la mission à modifier    
        $mission = mission::find($id);

        //Récuperer le client pour lequel on modifie la mission
        $oldClient = Client::find($mission->client_id);
        
        //Définir le titre de la page
        $title = 'Modifier la mission: '.Config('constants.options.PREFIX_MISSION').($mission->id);

        //Définir les paramètres du formulaire
        $route = ['missions.update',$id];
        $method = 'PUT';

        //Récuperer la liste des clients pour le formulaire(select)
        $listeClients = Client::where('prospect',0)
                            ->orderBy('nom_entreprise')
                            ->get();
        $clients=[];
        foreach($listeClients as $client){
            $clients[$client->id] = $client->nom_entreprise;
        }

        //Récuperer la liste des types de contrats pour le formulaire(select)
        $listTypesContrat = TypeContrat::all();
        $typesContrat = [];
        foreach($listTypesContrat as $type){
            $typesContrat[$type->id] = $type->type;
        }

        //Récuperer la liste des status pour le formulaire(select)
        $listStatus = DB::select(
            DB::raw("SHOW COLUMNS FROM mission WHERE FIELD = 'status'")
        )[0]->Type;
        preg_match('/^enum\((.*)\)$/', $listStatus, $matches);
        $listeStatus = [];
        foreach( explode(',', $matches[1]) as $value )
        {
            $v = trim( $value, "'" );
            $listeStatus = array_add($listeStatus, $v, $v);
        }

        //Récuperer la liste des fonctions  pour le formulaire(datalist)
        $fonctions = Fonction::all();

        return view('missions.create',[
                    'mission'=> $mission,
                    'title' => $title,
                    'route' => $route,
                    'method' => $method,
                    'clients' =>$clients,
                    'oldClient' => $oldClient,
                    'typesContrat' => $typesContrat,
                    'listeStatus' => $listeStatus,
                    'fonctions' => $fonctions
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
            'client_id'=> 'required',
            'fonction'=> 'required|max:80',
            'type_contrat_id'=>'required|numeric',
            'status'=>'required',
            //'contrat_id'=>'nullable',
            //'job_description_id'=>'nullable',  
            
        ],[
            'client_id.required'=>'Veuillez entrer le nom du client',
            
            'fonction.required'=>'Veuillez entrer la fonction recherchée',
            'fonction.max'=>'La fonction ne peut pas dépasser 80 caractères',

            'type_contrat_id.required'=>'Veuillez entrer le type de contrat',
            'type_contrat_id.numeric'=>'Le type du contrat est incorrecte',

            'status.required'=>'Veuillez entrer le type de status'
        ]);

        $extraSuccessMsg = '';
        $mission = Mission::find($id);
        $data = Input::all();

        //Retrouver la fonction correspondante ou l'ajouter dans la table Fonctions
        $fonction = Fonction::where(['fonction'=>$data['fonction']])
                                ->firstOrCreate(['fonction'=>$data['fonction']]);
        if($fonction->wasRecentlyCreated) {
            $extraSuccessMsg = 'Une nouvelle fonction a bien été ajoutée.';
        }

        $mission->fonction_id = $fonction->id;

        //Récuperer le  nouveau contrat chargé dans le formulaire
        $file = $request->file('contrat_id');
        
        if($file){

            //Déplacer le fichier dans le dossier de téléchargement public
            $filename = Storage::putFile('public/uploads/contrats',$file);

            //Récuperer le nouveau nom de fichier
            $filename = strrchr($filename,"/");
            
            //Récuperer l'url du dossier de téléchargement
            //à partir du fichier de config config/filesystems.php
            $url = '/uploads/contrats'.$filename;

            //Enregistrer le document dans la base de donnée
            $contrat = new Document ();
            $contrat->type = 'Contrat';
            $contrat->url_document = $url;
            $contrat->filename = $file->getClientOriginalName();

            if($contrat->save()){
                $oldContratId = $mission->contrat_id;
                $mission->contrat_id = $contrat->id;
                
                //Suppression de l'ancien contrat
                if($request->get('delete')) {
                    $oldContrat = Document::find($oldContratId);
                    
                    if(!Storage::disk('public')->delete($oldContrat->url_document)){
                        Session::push('errors','L\ancien contrat n\'a pas pu être supprimé du disque !');
                    } else {
                        if($oldContrat->delete()) {
                            Session::push('errors','L\ancien contrat n\'a pas pu être supprimé de la DB !');
                        }
                    }
                }
            } else{
                Session::push('errors','Erreur lors de l\'enregristrement du document (contrat)!');
            }
        //Il n'y a pas de nouveau contrat => sauver OU supprimer ancien contrat
        } elseif(empty($file) && !empty($request->get('contrat_id'))) {
            //Suppression de l'ancien contrat
            if($request->get('delete')) {
                $oldContrat = Document::find($request->get('contrat_id'));

                if(!Storage::disk('public')->delete($oldContrat->url_document)){
                    Session::push('errors','L\ancien contrat n\'a pas pu être supprimé du disque !');
                } else {
                    if(!$oldContrat->delete()) {
                        Session::push('errors','L\ancien contrat n\'a pas pu être supprimé !');
                    }
                }

                $mission->contrat_id = null;
            } else {  //Sauver ancien contrat
                $mission->contrat_id = $request->get('contrat_id');
            }
        //Aucun contrat pour cette mission
        } else {
            $mission->contrat_id = null;
        }
    
        
        if($mission->update($data)) {
            Session::put('success','La mission a bien été modifiée'.'<br \>'.$extraSuccessMsg);

        //Mise a jour des documents(job description)
        //Ajout des nouveaux documents
        //Déplacer le job description dans le dossier uploads
        $jobFiles = $request->file('job_description_ids');
        
            if($jobFiles){
                for($i=0;$i<count($jobFiles);$i++){
        
                    //Déplacer le fichier dans le dossier de téléchargement public
                    $filename = Storage::putFile('public/uploads/jobs',$jobFiles[$i]);
        
                    //Récuperer le nouveau nom de fichier
                    $filename = strrchr($filename,"/");
        
                    //Récuperer l'url du dossier de téléchargement
                    //à partir du fichier de config config/filesystems.php
                    $url = '/uploads/jobs'.$filename;
        
                    //Enregistrer le document dans la base de donnée
                    $job_desc = new Document ();
                    $job_desc-> type ='Job description';
                    $job_desc-> description = $request->input('descriptionsForJob') [$i];
                    $job_desc->url_document = $url;
                    $job_desc->filename = $jobFiles[$i]->getClientOriginalName();
                    $job_desc->mission_id = $mission->id;
        
                    if(!$job_desc->save()){
                        Session::push('errors','Erreur lors de l\'enregristrement du document (job description)!');
                    }
                }
            }

        //Suppression des anciens documents (job description)
            $deleteJobFileIds = $request->get('deleteJobFileIds');

            if($deleteJobFileIds){
                foreach($deleteJobFileIds as $deleteFileId){
                    $oldJobDesc = Document::find($deleteFileId);
                    if(!Storage::disk('public')->delete($oldJobDesc->url_document)){
                        Session::push('errors','L\ancien contrat n\'a pas pu être supprimé du disque !');
                    } else {
                        if(!$oldJobDesc->delete()) {
                            Session::push('errors','L\ancien job description n\'a pas pu être supprimé !');
                        }
                    }
                }
            }
        
        //Mise a jour des documents(offre)
        //Ajout des nouveaux documents
            //Déplacer l'offre dans le dossier uploads
            $offreFiles = $request->file('offre_ids');
            
                if($offreFiles){
                    for($i=0;$i<count($offreFiles);$i++){
            
                        //Déplacer le fichier dans le dossier de téléchargement public
                        $filename = Storage::putFile('public/uploads/offres',$offreFiles[$i]);
            
                        //Récuperer le nouveau nom de fichier
                        $filename = strrchr($filename,"/");
            
                        //Récuperer l'url du dossier de téléchargement
                        //à partir du fichier de config config/filesystems.php
                        $url = '/uploads/offres'.$filename;
            
                        //Enregistrer le document dans la base de donnée
                        $offre = new Document ();
                        $offre-> type ='Offre';
                        $offre-> description = $request->input('descriptionsForOffre') [$i];
                        $offre->url_document = $url;
                        $offre->filename = $offreFiles[$i]->getClientOriginalName();
                        $offre->mission_id = $mission->id;
            
                        if(!$offre->save()){
                            Session::push('errors','Erreur lors de l\'enregristrement du document (offre)!');
                        }
                    }
                }
    
            //Suppression des anciens documents (offre)
                $deleteOffreFileIds = $request->get('deleteOffreFileIds');
    
                if($deleteOffreFileIds){
                    foreach($deleteOffreFileIds as $deleteFileId){
                        $oldOffre = Document::find($deleteFileId);
                        if(!Storage::disk('public')->delete($oldOffre->url_document)){
                            Session::push('errors','L\ancien contrat n\'a pas pu être supprimé du disque !');
                        } else {
                            if(!$oldOffre->delete()) {
                                Session::push('errors','L\ancienne offre n\'a pas pu être supprimée !');
                            }
                        }
                    }
                }
        } else {
            Session::push('errors','Une erreur s\'est produite lors de la modification!');
        }

        return redirect()->route('missions.show',$id);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mission = Mission::find($id);
        $clientId = $mission->client_id;
        
                try {
                    if(isset($mission) && $mission->delete()){
                        Session::put('success','La mission a bien été supprimé');
                    }else {
                        Session::push('errors','Une erreur s\'est produite lors de la suppression de la mission!');
                    }
        
                } catch (\Exception $ex){
                        Session::push('errors','Impossible de supprimer cette mission (supprimer les candidats avant)!');
                }
        
                return redirect()->route('clients.show', $clientId);
            
    }
}
