<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use App\Notifications\MailResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname',
        'firstname',
        'initials',
        'language',
        'login', 
        'email', 
        'api_token', 
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     *  
     * @var array proriétés virtuelles
     */
    protected $appends = ['is_admin'];

    /**
     * Détermine si l'utilisateur est un administrateur
     */
    public function getIsAdminAttribute() {
        return $this->roles()->where('name','=','admin')->get()->isNotEmpty();
    }

    /**
     *Récupère les roles associés a cet utilisateur
     *
     * 
     */
    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Récuperer les missions créer par cet utilisateur
     */
    public function missions(){
        return $this->hasMany('App\Mission');
    }


    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

     /**
     * 
     *
     * @param  string|array $roles
     * 
     */
    public function authorizeRoles($roles){
        if(is_array($roles)) {
            return $this->hasAnyRole($roles) || 
                abort(401,'This action is unauthoraized');
        }

        return $this->hasRole($roles) || 
            abort(401,'This action is unauthoraized');
    }

    /**
     * Check multiples roles
     * @param array $roles
     * @return boolean
     */
    public function hasAnyRole($roles){
        return null !== $this->roles()->whereIn('name',$roles)->first();
    }

    /**
     * Check one role
     * @param string $role
     * @return boolean
     */
    public function hasRole($role){
        return null !== $this->roles()->where('name',$role)->first();
    }
}
