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
use App\Role;
use Illuminate\Support\Facades\Hash;




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
        parent::__construct();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {  
        return Validator::make($data, [
            'lastname' => 'required|string|max:60',
            'firstname' => 'required|string|max:60',
            'initials' => 'required|string|max:2|unique:users',
            'language' => 'required|string|max:2',
            'login' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:250|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'initials' => $data['initials'],
            'language' => $data['language'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $role = Role::find($data['role']);

        if($role) {
            $user->roles()->attach($role);
        } else {
            $user->roles()->attach(Role::where('name','employee')->first());
        }

        //return $user
        return auth()->user();

        return $user;
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
            'role' => 'nullable|numeric',
            'language' => 'required|string|max:2',
            'email' => [
                'required',
                'string',
                'email',
                'max:250',
                Rule::unique('users')->ignore($id),
            ],
            'old_password' => 'nullable|string|min:6',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = User::find($id);
        $data = Input::all();

        //Modification éventuelle de mot de passe
        if(empty($data['password']) && empty($data['password_confirmation']) ) {
            unset($data['password']);
            unset($data['password_confirmation']);
        } elseif(!empty($data['password'])) {
            $oldPassword = isset($data['old_password']) ?  $data['old_password']:'';
            if(Hash::check($oldPassword,$user->password)) {
                $data['password'] = bcrypt($data['password']);                
            } else {
                unset($data['password']); //Retirer le nouveau mot de passe avant sauvegarde                
                Session::push('errors',__('passwords.error_old_password'));                
            }
        }
       
        //Modificaton éventuelle du rôle(action réservé aux admin)
        if(isset($data['role'])) {
            $role = Role::find($data['role']);

            $userRoles = auth()->user()->roles()->get()->toArray();
            array_walk($userRoles, function(&$item) { $item = $item['name']; });

            if($role && in_array('admin',$userRoles)) {
                if(auth()->user()->id==$id && $role->name!='admin') {
                    Session::push('errors',__('general.set_role_admin_to_employee_forbidden'));
                }else {
                    $user->roles()->sync($role);
                }
            }
        } 


        if($user->update($data)){
            Session::put('success',__('general.record_saved',['record'=>'user']));

        } else {
            Session::push('errors',__('general.error_saving'));

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
        $route = 'register';
        $method = 'POST';
        $languages = ['en'=>'English','fr'=>'Français','nl'=>'Nederlands'];
        $listRoles = Role::all()->toArray();
        
        $roles = [];
        foreach($listRoles as $role) {
            $roles[$role['id']] = $role['name'];
        }


        return view('users.create',[
            'route' => $route,
            'method' => $method,
            'languages' => $languages,
            'roles' => $roles,
        ]);
    }


}
