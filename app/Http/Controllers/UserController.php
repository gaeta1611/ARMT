<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
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
        $users = User::whereRaw('login !=""')->get();

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
            'lastname.required'=>__('general.error_user_lastname'),
            'lastname.max'=>__('general.error_user_lastname_caractere'),

            'firstname.required'=>__('general.error_user_firsname'),
            'firstname.max'=>__('general.error_user_firstname_caractere'),

            'initials.required'=>__('general.error_initials'),
            'initials.max'=>__('general.error_two_caractere_initials'),
            'initials.unique'=>__('general.error_initials_already_exist'),

            'language.required'=>__('general.error_choice_language'),
            'language.max'=>__('general.error_language_caractere'),

            'login.required'=>__('general.error_login'),
            'login.max'=>__('general.error_login_caractere'),
            'login.unique'=>__('general.error_login_already_exist'),
            
            'email.required'=>__('general.error_email'),
            'email.email'=>__('general.error_type_email'),
            'email.unique'=>__('general.error_exist_email'),
            'email.max'=>__('general.error_email_caractere'),

            'password.required'=>__('general.error_password'),
            'password.min'=>__('general.error_password_caractere'),
            'password.confirmed'=>__('general.error_password_confirmed'),
        ]);


        $user = new User(Input::all());

        if($user->save()){
            Session::put('success',__('general.succes_save_user'));
        } else{
            Session::push('errors',__('general.error_general'));

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

        return view('users.show',[
            'user'=>$user,
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
        $listRoles = Role::all()->toArray();
        
        $roles = [];
        foreach($listRoles as $role) {
            $roles[$role['id']] = $role['name'];

            if($role['name']=='employee'){
                $roleEmployeeId = $role['id'];
            }
        }
        
        return view('users.create',[
            'user'=> $user,
            'title' => $title,
            'route' => $route,
            'method' => $method,
            'languages' => $languages,
            'roles' => $roles,
            'roleEmployeeId' => $roleEmployeeId,
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
                //Un utilisateur qui n'a pas crée de mission peut etre supprimé
                if(isset($user) && $user->delete()){
                    Session::put('success',__('general.succes_delete_user'));
                }else {
                    Session::push('errors',__('general.error_general_delete'));
                }

            } catch (\Exception $ex){
                if(preg_match("/mission_created_by_user/", $ex->getMessage())){
                    $user->firstname = '';
                    $user->lastname = '';
                    $user->login = null;
                    $user->email = null;
                    $user->language = '';
                    $user->password = '';
                    $user->remember_token = null;
                
                    if($user->save()) {
                        Session::put('success',__('general.succes_delete_user'));
                    } else {
                        Session::push('errors',__('general.impossible_user_delete'));
                    }
                } else {
                    Session::push('errors',__('general.impossible_user_delete'));
                }           
            }
        } else {
            Session::push('errors',__('general.impossible_user_connected_delete'));
        }

        return redirect()->route('users.index');
    }
}
