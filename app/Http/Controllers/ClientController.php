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
    public function index(Request $request)
    {
        
        if($request->query('status')=='client'){
            $clients = Client::whereProspect('0')->get();
        } elseif($request->query('status')=='prospect') {
            $clients = Client::whereProspect('1')->get();
        } else {
            $clients = Client::all();
        }

        $counters = [
            'all'=> Client::all()->count(),
            'client'=>Client::whereProspect('0')->count(),
            'prospect'=>Client::whereProspect('1')->count()
        ];

        //Envoyer les données à la vue ou rediriger
        return view ('clients.index')->with([
            'clients'=>$clients,
            'counters'=>$counters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('general.titles.add_client_prospect');
        $route = 'clients.store';
        $method = 'POST';

        //Récuperer la liste des localite pour le formulaire(datalist)
        $localites = Localite::all();
        
        return view('clients.create',[
                    'title' => $title,
                    'route' => $route,
                    'method' => $method,
                    'localites' => $localites,
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
            'email'=>'required|email|unique:client|max:100',
            'adresse'=>'max:255',
            'localite_id' => 'nullable|numeric',
            'code_postal' => 'max:10',
            'localite' => 'max:120',
            'tva'=>'max:15',
            'site'=>'nullable|url|unique:client|max:255',
            'linkedin'=>'nullable|url|unique:client|max:255',
            'prospect'=>'required|boolean',

        ],[
            'nom_entreprise.required'=>__('general.error_company_name'),
            'nom_entreprise.unique'=>__('general.error_exist_company'),
            'nom_entreprise.max'=>__('general.error_company_caractere'),

            'personne_contact.max'=>__('general.error_person_contact_caractere'),
            'telephone.max'=>__('general.error_phone_caractere'),

            'email.email'=>__('general.error_type_email'),
            'email.unique'=>__('general.error_exist_email'),
            'email.max'=>__('general.error_email_caractere'),
            'email.required'=>__('general.error_email'),

            //'adresse.required'=>'Veuillez entrer une adresse',
            'adresse.max'=>__('general.error_address_caractere'),

            'localite_id.numeric' =>__('general.error_type_localite'),
            //'code_postal.required' => 'Veuillez entrer un code postal.',
            'code_postal.max' =>__('general.error_zip_caractere'),
            //'localite.required' => 'Veuillez entrer une localité.',
            'localite.max' =>__('general.error_localite_caractere'),

            //'tva.required'=>'Veuillez entrer un numéro de TVA',
            'tva.max'=>__('general.error_tva_caractere'),

            'site.url'=>__('general.error_valide_website'),
            'site.unique'=>__('general.error_db_website'),
            'site.max'=>__('general.error_website_caractere'),

            'linkedin.url'=>__('general.error_valide_linkedin'),
            'linkedin.unique'=>__('general.error_db_linkedin'),
            'linkedin.max'=>__('general.error_linkedin_caractere'),

            'prospect.required'=>__('general.error_nature_company'),
            'prospect.boolean'=>__('general.error_type_type'),
        ]);

        $client = new Client(Input::all());
        $data = Input::all();

        //Ajout éventuel d'une nouvelle localité
        if($data['localite_id']==null) {     
            if($data['code_postal']!='' && $data['localite']!='') {
                //Rechercher si la localité existe déja dans la DB
                $localite = Localite::where('code_postal',$data['code_postal'])->get()->first();

                if($localite) {
                    $client->localite_id = $localite->id;
                } else {
                    $localite = new Localite();
                    $localite->code_postal = $data['code_postal'];
                    $localite->localite = $data['localite'];
                    
                    if($localite->save()) {
                        $client->localite_id = $localite->id;
                        
                        Session::put('success',__('general.succes_locality'));
                    } else {
                        Session::push('errors',__('general.error_locality'));
                        
                        return redirect()->route('clients.create');
                    }
                }
            }
        }

        if($client->save()){
            Session::put('success',__('general.success_client_save'));
        }
        else{
            Session::push('errors',__('general.error_general'));
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
        $title = ($client->prospect ? ucfirst(trans_choice('general.prospect',1)) : ucfirst(trans_choice('general.client',1))).' : '.$client->nom_entreprise;
        

        //TODO réglé relation many to one
        $localite = Localite::find($client->localite);

        return view('clients.show',[
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
        $client = Client::find($id);
        $title = __('general.edit').' : '.$client->nom_entreprise;
        $route = ['clients.update',$id];
        $method = 'PUT';

        //Récuperer la liste des localite pour le formulaire(datalist)
        $localites = Localite::all();

        return view('clients.create',[
            'client'=> $client,
            'title' => $title,
            'route' => $route,
            'method' => $method,
            'localites' => $localites
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
                'required',
                'email',
                Rule::unique('client')->ignore($id),
                'max:100'
            ],
            'adresse'=>'max:255',
            'localite_id' => 'nullable|numeric',
            'code_postal' => 'max:10',
            'localite' => 'max:120',
            'tva'=>'max:15',
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
            'nom_entreprise.required'=>__('general.error_company_name'),
            'nom_entreprise.unique'=>__('general.error_exist_company'),
            'nom_entreprise.max'=>__('general.error_company_caractere'),

            'personne_contact.max'=>__('general.error_person_contact_caractere'),
            'telephone.max'=>__('general.error_phone_caractere'),

            'email.email'=>__('general.error_type_email'),
            'email.unique'=>__('general.error_exist_email'),
            'email.max'=>__('general.error_email_caractere'),
            'email.required'=>__('general.error_email'),

            //'adresse.required'=>'Veuillez entrer une adresse',
            'adresse.max'=>__('general.error_address_caractere'),

            'localite_id.numeric' =>__('general.error_type_localite'),
            //'code_postal.required' => 'Veuillez entrer un code postal.',
            'code_postal.max' =>__('general.error_zip_caractere'),
            //'localite.required' => 'Veuillez entrer une localité.',
            'localite.max' =>__('general.error_localite_caractere'),

            //'tva.required'=>'Veuillez entrer un numéro de TVA',
            'tva.max'=>__('general.error_tva_caractere'),

            'site.url'=>__('general.error_valide_website'),
            'site.unique'=>__('general.error_db_website'),
            'site.max'=>__('general.error_website_caractere'),

            'linkedin.url'=>__('general.error_valide_linkedin'),
            'linkedin.unique'=>__('general.error_db_linkedin'),
            'linkedin.max'=>__('general.error_linkedin_caractere'),
        ]);

        $client = Client::find($id);
        $data = Input::all();

        //Ajout éventuel d'une nouvelle localité 
        if($data['code_postal']!='' && $data['localite']!='') {
            //Rechercher si la localité existe déja dans la DB
            $localite = Localite::where('code_postal',$data['code_postal'])->get()->first();

            if($localite) {
                $data['localite_id'] = $localite->id;
            } else {
                $localite = new Localite();
                $localite->code_postal = $data['code_postal'];
                $localite->localite = $data['localite'];
                
                if($localite->save()) {
                    $data['localite_id'] = $localite->id;
                    
                    Session::put('success',__('general.succes_locality'));
                } else {
                    Session::push('errors',__('general.error_locality'));
                    
                    return redirect()->route('clients.update');
                }
            }
        }
        
       
        if($client->update($data)){
            Session::put('success',__('general.success_client_save'));
        }
        else{
            Session::push('errors',__('general.error_general'));
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
                Session::put('success',__('general.success_client_delete'));
            }else {
                Session::push('errors',__('general.error_client_delete'));
            }

        } catch (\Exception $ex){
                Session::push('errors',__('general.impossible_client_delete'));
        }

        return redirect()->route('clients.index');
    }
}
