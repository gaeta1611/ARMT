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
        $title = __('general.titles.add_mission');
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
            
            //__('general.'),
        ],[
            'client_id.required'=>__('general.error_client_name'),
            
            'fonction.required'=>__('general.error_function_name'),
            'fonction.max'=>__('general.error_function_caractere'),

            'type_contrat_id.required'=>__('general.error_type_contract'),
            'type_contrat_id.numeric'=>__('general.error_type_incorrect'),

            'status.required'=>__('general.error_type_status'),
        ]);

        $extraSuccessMsg = '';

        $mission = new Mission(Input::all());
        $mission->user_id = auth()->user()->id;
        $data = Input::all('fonction');

        //Retrouver la fonction correspondante ou l'ajouter dans la table Fonctions
        $fonction = Fonction::where(['fonction'=>$data['fonction']])
                                ->firstOrCreate(['fonction'=>$data['fonction']]);
        if($fonction->wasRecentlyCreated) {
            $extraSuccessMsg =__('general.succes_add_function');
        }

        $mission->fonction_id = $fonction->id;
        
        //Récuperer le fichier chargé dans le formulaire
        $mission->contrat_id = null;        
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
            $contrat->user_id = auth()->user()->id;

            if(!$contrat->save()){
                Session::push('errors',__('general.error_contract_save'));
            } else {
                $mission->contrat_id = $contrat->id;
            }
        }
        
        if($mission->save()){
            Session::put('success',__('general.success_mission_save').'<br \>'.$extraSuccessMsg);
            
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
                    $job_desc->user_id = auth()->user()->id;
        
                    if(!$job_desc->save()){
                        Session::push('errors',__('general.error_job_save'));
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
                        $offre->user_id = auth()->user()->id;
                        
                        
            
                        if(!$offre->save()){
                            Session::push('errors',__('general.error_offre_save'));
                        }
                    }
                }
        } else {
            Session::push('errors',__('general.error_general'));
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
        $title = ucfirst(trans_choice('general.mission',1)).' : '.$mission->user()->get()->first()->initials.($mission->id);

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
        $mission = Mission::find($id);

        if(!$mission) {
            return redirect()->route('missions.index');
        }

        //Récuperer le client pour lequel on modifie la mission
        $oldClient = Client::find($mission->client_id);
        
        //Définir le titre de la page
        $title = __('general.titles.edit_mission').' : '.$mission->user()->get()->first()->initials.$mission->id;

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
            'client_id.required'=>__('general.error_client_name'),
            
            'fonction.required'=>__('general.error_function_name'),
            'fonction.max'=>__('general.error_function_caractere'),

            'type_contrat_id.required'=>__('general.error_type_contract'),
            'type_contrat_id.numeric'=>__('general.error_type_incorrect'),

            'status.required'=>__('general.error_type_status'),
        ]);

        $extraSuccessMsg = '';
        $mission = Mission::find($id);
        $data = Input::all();

        //Retrouver la fonction correspondante ou l'ajouter dans la table Fonctions
        $fonction = Fonction::where(['fonction'=>$data['fonction']])
                                ->firstOrCreate(['fonction'=>$data['fonction']]);
        if($fonction->wasRecentlyCreated) {
            $extraSuccessMsg = __('general.succes_add_function');
        }

        $mission->fonction_id = $fonction->id;

        //Récuperer le  nouveau contrat chargé dans le formulaire
        $file = $request->file('contrat_id');

        //Seul l'admin ou le créateur de la mission peut modifier le contrat
        if(auth()->user()->is_admin || auth()->user()->id==$mission->user_id) {
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
                $contrat->user_id = auth()->user()->id;
                

                if($contrat->save()){
                    $oldContratId = $mission->contrat_id;
                    $mission->contrat_id = $contrat->id;
                    
                    //Suppression de l'ancien contrat
                    if($request->get('delete')) {
                        $oldContrat = Document::find($oldContratId);
                        
                        if(!Storage::disk('public')->delete($oldContrat->url_document)){
                            Session::push('errors',__('general.error_contract_delete_disk'));
                        } else {
                            if($oldContrat->delete()) {
                                Session::push('errors',__('general.error_rapport_delete'));
                            }
                        }
                    }
                } else{
                    Session::push('errors',__('general.error_contract_save'));
                }
            //Il n'y a pas de nouveau contrat => sauver OU supprimer ancien contrat
            } elseif(empty($file) && !empty($request->get('contrat_id'))) {
                //Suppression de l'ancien contrat
                if($request->get('delete')) {
                    $oldContrat = Document::find($request->get('contrat_id'));

                    if(!Storage::disk('public')->delete($oldContrat->url_document)){
                        Session::push('errors',__('general.error_contract_delete_disk'));
                    } else {
                        if(!$oldContrat->delete()) {
                            Session::push('errors',__('general.error_rapport_delete'));
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
        } else { //Modification du contat non autorisée
            unset($data['contrat_id']);
        }
    
        
        if($mission->update($data)) {
            Session::put('success',__('general.success_mission_edit').'<br \>'.$extraSuccessMsg);

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
                    $job_desc->user_id = auth()->user()->id;
                    
        
                    if(!$job_desc->save()){
                        Session::push('errors',__('general.error_job_save'));
                    }
                }
            }

        //Suppression des anciens documents (job description)
            $deleteJobFileIds = $request->get('deleteJobFileIds');

            if($deleteJobFileIds){
                foreach($deleteJobFileIds as $deleteFileId){
                    $oldJobDesc = Document::find($deleteFileId);
                    if(!Storage::disk('public')->delete($oldJobDesc->url_document)){
                        Session::push('errors',__('general.error_job_delete_disk'));
                    } else {
                        if(!$oldJobDesc->delete()) {
                            Session::push('errors',__('general.error_job_delete'));
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
                        $offre->user_id = auth()->user()->id;
                        
            
                        if(!$offre->save()){
                            Session::push('errors',__('general.error_offre_save'));
                        }
                    }
                }
    
            //Suppression des anciens documents (offre)
                $deleteOffreFileIds = $request->get('deleteOffreFileIds');
    
                if($deleteOffreFileIds){
                    foreach($deleteOffreFileIds as $deleteFileId){
                        $oldOffre = Document::find($deleteFileId);
                        if(!Storage::disk('public')->delete($oldOffre->url_document)){
                            Session::push('errors',__('general.error_offre_delete_disk'));
                        } else {
                            if(!$oldOffre->delete()) {
                                Session::push('errors',__('general.error_offre_delete'));
                            }
                        }
                    }
                }
        } else {
            Session::push('errors',__('general.error_edit'));
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
                        Session::put('success',__('general.success_mission_delete'));
                    }else {
                        Session::push('errors',__('general.error_mission_delete'));
                    }
        
                } catch (\Exception $ex){
                        Session::push('errors',__('general.impossible_mission_delete'));
                }
        
                return redirect()->route('clients.show', $clientId);
            
    }
}
