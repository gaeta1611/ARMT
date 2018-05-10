<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Candidat;
use App\Mission;
use App\Client;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if($user && $user->authorizeRoles(['admin','employee'])) {
            return redirect()->action('MissionController@index');
        }

        return view('auth.login');
    }

   /**
     * Retrieve all the candidate that correspond to criteria in given form.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $data = Input::all('keyword');      
        $keyword = $data['keyword'];      

        $candidats = Candidat::select(['candidat.id','candidat.nom','candidat.prenom'])
                ->where('nom','LIKE',"%$keyword%")
                ->orWhere('prenom','LIKE',"%$keyword%")
                ->orWhereRaw("LOCATE(LOWER('$keyword'),LOWER(concat(nom,' ',prenom)))!=0")
                ->orWhereRaw("LOCATE(LOWER('$keyword'),LOWER(concat(prenom,' ',nom)))!=0")
                ->get();
        
        $clients = Client::select(['client.id','client.nom_entreprise','client.personne_contact'])
                ->where('nom_entreprise','LIKE',"%$keyword%")
                ->orWhere('personne_contact','LIKE',"%$keyword%")
                ->get();
        
        $missions = DB::table('mission')->select('mission.id',DB::Raw("concat(users.initials,`mission`.id) as prefixed"))
                ->join('users','user_id','users.id')
                ->where('mission.id','LIKE',"%$keyword%")
                ->orWhereRaw("concat(users.initials,`mission`.id) LIKE '%$keyword%'")
                ->get();

        $results = [
            'candidats' => $candidats->toArray(),
            'clients' => $clients->toArray(),
            'missions' => $missions->toArray(),
        ];
        
        return response()->json(['keyword'=>$keyword,'result'=>$results]);
    }
}
