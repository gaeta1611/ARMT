<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Récuperer les données
        $users = User::all();

        //Envoyer les données à la vue ou rediriger
        return view ('users.index',[
            'users'=>$users,
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
            'lastname' => 'required|string|max:60',
            'firstname' => 'required|string|max:60',
            'initials' => 'required|string|max:2|unique:users',
            'language' => 'required|string|max:2',
            'login' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:250|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ],[
            'lastname.required'=>'Veuillez entrer le nom',
            'lastname.max'=>'Le nom  ne peut pas dépasser 60 caractères',

            'firstname.required'=>'Veuillez entrer le prénom',
            'firstname.max'=>'Le prénomne peut pas dépasser 60 caractères',

            'initials.required'=>'Veuillez entrer les initiales du candidat',
            'initials.max'=>'Veuillez entrer 2 caractères pour les initiales',
            'initials.unique'=>'Ces initiales existent déjà',

            'language.required'=>'Veuillez une langue préférée',
            'language.max'=>'Le choix de la langue ne peut pas dépasser 2 caractères',

            'login.required'=>'Veuillez entrer le login',
            'login.max'=>'Le login ne peut pas dépasser 20 caractères',
            'login.unique'=>'Ce login existent déjà',

            'email.required'=>'Veuillez entrer un email',
            'email.email'=>'Veuillez entrer un email valide',
            'email.unique'=>'Cet email existe déjà',
            'email.max'=>'L\email ne peut pas dépasser 250 caractères',

            'password.required'=>'Veuillez entrer un mot de passe',
            'password.min'=>'Le mot de passe doit comporter au moins 6 caractères',
            'password.confirmed'=>'Veuillez confirmer le mot de passe doit',
        ]);


        $user = new User(Input::all());

        if($user->save()){
            Session::put('success',"L\'utilisateur a bien été enregistré");
        } else{
            Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');

            return redirect()->route('users.create');
        }

        return redirect()->route('users.index');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $title = 'Utilisateur : '.($user->firstname).' '.($user->lastname);


        return view('users.show',[
            'user'=>$user,
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
        $user = User::find($id);
        $title = 'Modifier utilisateur';
        $route = ['profile.update',$id];
        $method = 'PUT';
        $languages = ['en'=>'English','fr'=>'Français','nl'=>'Nederlands'];
        
        return view('users.create',[
            'user'=> $user,
            'title' => $title,
            'route' => $route,
            'method' => $method,
            'languages' => $languages,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->id != Auth::id()) {
            try {
                if(isset($user) && $user->delete()){
                    Session::put('success',"L'utilisateur a bien été supprimé");
                }else {
                    Session::push('errors','Une erreur s\'est produite lors de la suppression!');
                }

            } catch (\Exception $ex){
                    Session::push('errors','Impossible de supprimer cet utilisateur');
            }
        } else {
            Session::push('errors',"Impossible de supprimer l'utilisateur connecté");
        }

        return redirect()->route('users.index');
    }
}
