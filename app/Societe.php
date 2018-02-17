<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Societe extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom_entreprise',
        'designation',
        'finalite',
        'niveau',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'societes';

    /**
     * Récuperer les fonctions associés à cette société
     */
    public function fonctions (){
        return $this->belongsToMany('App\Fonction','societe_candidat','fonction_id','societe_id');
    }

     /**
     * Récuperer les emplois associés à cette société
     */
    public function candidatSocietes(){
        return $this->hasMany('App\CandidatSociete');
    }
}
