<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Localite;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Vérifier les permission d'accès
       
        //Récuperer les données
        $clients = Client::all()->where('prospect',0);

        //Traiter les données

        //Envoyer les données à la vue ou rediriger
        return view ('clients.index')->with('clients',$clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Ajouter client';
        $route = 'clients.store';
        $method = 'POST';
        
        return view('clients.create',[
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
            'nom_entreprise'=> 'required|unique:client|max:60',
            'personne_contact'=> 'max:100',
            'telephone'=>'max:20',
            'email'=>'email|unique:client|max:100',
            'adresse'=>'required|max:255',
            'localite'=>'required|numeric',
            'tva'=>'required|max:15',
            'site'=>'nullable|url|unique:client|max:255',
            'linkedin'=>'nullable|url|unique:client|max:255'

        ],[
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
        ]);

        $client = new client(Input::all());
        $client->prospect = 0;
        if($client->save()){
            Session::put('success','Le client a bien été enregistré');
        }
        else{
            Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
        }

        return redirect()->route('clients.index');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        $title = 'Profil '.($client->prospect ? 'prospect':'client');

        //TODO réglé relation many to one
        $localite = Localite::find($client->localite);
        return view('clients.show',[
            'client'=>$client,
            'title' =>$title,
            'client_localite' =>$localite
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
        $client = Client::find($id);
        $title = 'Modifier client';
        $route = ['clients.update',$id];
        $method = 'PUT';

        return view('clients.create',[
            'client'=> $client,
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
            'nom_entreprise'=> [
                'required',
                Rule::unique('client')->ignore($id),
                'max:60'
            ],
            'personne_contact'=> 'max:100',
            'telephone'=>'max:20',
            'email'=>[
                'email',
                Rule::unique('client')->ignore($id),
                'max:100'
            ],
            'adresse'=>'required|max:255',
            'localite'=>'required|numeric',
            'tva'=>'required|max:15',
            'site'=>[
                'nullable',
                'url',
                Rule::unique('client')->ignore($id),
                'max:255'
            ],
            'linkedin'=>[
                'nullable',
                'url',
                Rule::unique('client')->ignore($id),
                'max:60'
            ]

        ],[
            'nom_entreprise.required'=>'Veuillez entrer le nom d\'une entreprise',
            'nom_entreprise.unique'=>'Ce nom d\'entreprise existe déjà',
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
            'linkedin.max'=>'L\' URL de Linkedin ne peut pas dépasser 255 caractères'
        ]);

        $client = Client::find($id);
        $data = Input::all();
       
        if($client->update($data)){
            Session::put('success','Le client a bien été enregistré');
        }
        else{
            Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');
        }

        return redirect()->route('clients.show',$id);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        try {
            if(isset($client) && $client->delete()){
                Session::put('success','Le client a bien été supprimé');
            }else {
                Session::push('errors','Une erreur s\'est produite lors de la suppression du client!');
            }

        } catch (\Exception $ex){
                Session::push('errors','Impossible de supprimer ce client (supprimer les missions avant)!');
        }

        return redirect()->route('clients.index');
    }
}
