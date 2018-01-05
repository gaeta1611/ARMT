<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Mission;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

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
        $title = 'Ajouter mission';
        $route = 'missions.store';
        $method = 'POST';

        $listeClients = $clients = Client::where('prospect',0)
                            ->orderBy('nom_entreprise')
                            ->get();

        $clients=[];
        foreach($listeClients as $client){
            $clients[$client->id] = $client->nom_entreprise;
        }

        $oldClient = Client::find($id);
        
        return view('missions.create',[
                    'title' => $title,
                    'route' => $route,
                    'method' => $method,
                    'clients' =>$clients,
                    'oldClient' => $oldClient
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
            'status'=>'required|numeric',
            'contrat_id'=>'nullable|numeric',
            'job_description_id'=>'nullable|numeric',
            
        ],[
            'client_id.required'=>'Veuillez entrer le nom du client',
            
            'fonction.required'=>'Veuillez entrer la fonction recherchée',
            'fonction.max'=>'La fonction ne peut pas dépasser 120 caractères',

            'type_contrat_id.required'=>'Veuillez entrer le type de contrat',
            'type_contrat_id.numeric'=>'Le type du contrat est incorrecte',

            'status.required'=>'Veuillez entrer le type de status',
            'status.numeric'=>'Le type du status est incorrecte',

            'contrat_id.numeric'=>'Le type du document contrat est incorrecte',

            'job_description_id.numeric'=>'Le type du document job description est incorrecte',
        ]);

        $mission = new mission(Input::all());
        
        if($mission->save()){
            Session::put('success','La mission a bien été enregistrée');
        }
        else{
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
        //
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
        //
    }
}
