<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom_entreprise',
        'personne_contact',
        'telephone',
        'email',
        'adresse',
        'localite_id',
        'site',
        'linkedin',
        'tva',
        'prospect',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'client';

     /**
     * Récuperer la localité associée au client
     */
    public function localite(){
        return $this->belongsTo('App\Localite');
    }

     /**
     * Récuperer les missions  associée au client
     */
    public function missions(){
        return $this->hasMany('App\Mission');
    }

    
}
