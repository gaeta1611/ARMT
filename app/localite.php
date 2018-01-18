<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localite extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_postal',
        'localite',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'localite';

     /**
     * Récuperer les clients associés à la localité
     */
    public function mission (){
        return $this->hasMany('App\Client');
    }

    /**
     * Récuperer les candidats associés à la localité
     */
    public function candidat (){
        return $this->hasMany('App\Candidat');
    }
    
}
