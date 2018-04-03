<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {  
        $messages = [
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
        ];
        return Validator::make($data, [
            'lastname' => 'required|string|max:60',
            'firstname' => 'required|string|max:60',
            'initials' => 'required|string|max:2|unique:users',
            'language' => 'required|string|max:2',
            'login' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:250|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'initials' => $data['initials'],
            'language' => $data['language'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
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
            //'lastname' => 'required|string|max:60',
            //'firstname' => 'required|string|max:60',
            /*'initials' => [
                'required',
                'string',
                'max:2',
                Rule::unique('users')->ignore($id),
            ],*/
            'language' => 'required|string|max:2',
            /*'login' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($id),
            ],*/
            'email' => [
                'required',
                'string',
                'email',
                'max:250',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'nullable|string|min:6|confirmed',
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

            'password.min'=>'Le mot de passe doit comporter au moins 6 caractères',
            'password.confirmed'=>'Veuillez confirmer le mot de passe doit',
        ]);

        $user = User::find($id);
        $data = Input::all();

        if(empty($data['password']) && empty($data['password_confirmation']) ) {
            unset($data['password']);
            unset($data['password_confirmation']);
        } elseif(!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if($user->update($data)){
            Session::put('success',"L'utilisateur a bien été enregistré");

        } else {
            Session::push('errors','Une erreur s\'est produite lors de l\'enregristrement!');

            return redirect()->route('users.edit',$id);
        }

        return redirect()->route('users.show',$id);
    }

    /**
     * 
     * @return /Illuminate/Http/Response
     */
    public function showRegistrationForm() 
    {
        $title = 'Ajouter un utilisateur';
        $route = 'register';
        $method = 'POST';
        $languages = ['en'=>'English','fr'=>'Français','nl'=>'Nederlands'];


        return view('users.create',[
            'title' => $title,
            'route' => $route,
            'method' => $method,
            'languages' => $languages,
        ]);
    }


}
