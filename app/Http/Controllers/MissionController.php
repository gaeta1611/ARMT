<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Mission;
use App\TypeContrat;
use App\Document;
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
    public function index()
    {
        //
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

        return view('missions.create',[
                    'title' => $title,
                    'route' => $route,
                    'method' => $method,
                    'clients' =>$clients,
                    'oldClient' => $oldClient,
                    'typesContrat' => $typesContrat,
                    'listeStatus' => $listeStatus
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
            'fonction'=> 'required|max:120',
            'type_contrat_id'=>'required|numeric',
            'status'=>'required',
            //'contrat_id'=>'nullable',
            //'job_description_id'=>'nullable',
            
        ],[
            'client_id.required'=>'Veuillez entrer le nom du client',
            
            'fonction.required'=>'Veuillez entrer la fonction recherchée',
            'fonction.max'=>'La fonction ne peut pas dépasser 120 caractères',

            'type_contrat_id.required'=>'Veuillez entrer le type de contrat',
            'type_contrat_id.numeric'=>'Le type du contrat est incorrecte',

            'status.required'=>'Veuillez entrer le type de status'
        ]);

        //Déplacer le contrat dans le dossier uploads
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
            $contrat-> type ='Contrat';
            $contrat->url_document = $url;
            $contrat->filename = $file->getClientOriginalname();

            if(!$contrat->save()){
                Session::push('errors','Erreur lors de l\'enregristrement du document (contrat)!');
            }
        }
        
        $mission = new mission(Input::all());
        $mission->contrat_id = $file ? $contrat->id:null;
        
        if($mission->save()){
            Session::put('success','La mission a bien été enregistrée');

            //Déplacer le contrat dans le dossier uploads
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
                    $job_desc-> description = $request->input('descriptions') [$i];
                    $job_desc->url_document = $url;
                    $job_desc->filename = $file->getClientOriginalname();
                    $job_desc->mission_id = $mission->id;
        
                    if(!$job_desc->save()){
                        Session::push('errors','Erreur lors de l\'enregristrement du document (job description)!');
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
        $title = 'Détails de la mission ';

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
        $mission = mission::find($id);
        $title = 'Modifier mission';
        $route = ['missions.update',$id];
        $method = 'PUT';

        return view('missions.create',[
            'mission'=> $mission,
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
        //
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
