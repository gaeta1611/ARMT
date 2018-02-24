<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiplomeEcole extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'diplome_id',
        'ecole_id',
        
    ];

    /**
     * Gestion automatique des champs created_at et updated_at
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'diplomes_ecoles';
    
     /**
     * Récuperer le diplome associés a cette ecole
     */
    public function diplome(){
        return $this->belongsTo('App\Diplome');
    }

     /**
     * Récuperer l'ecole associé à ce diplome'
     */
    public function ecole(){
        return $this->belongsTo('App\Ecole');
    }

     /**
     * Récuperer les candidats associé a ce diplome pour cette ecole
     */
    public function candidatDiplomeEcoles(){
        return $this->hasMany('App\CandidatDiplomeEcole','diplome_ecole_id','id');
    }
}
