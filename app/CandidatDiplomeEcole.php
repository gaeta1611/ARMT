<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidatDiplomeEcole extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'candidat_id',
        'diplome_ecole_id',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'candidat_diplome_ecole';

    /**
     * Gestion automatique des champs created_at et updated_at
     *
     * @var boolean
     */
    public $timestamps = false;
    
     /**
     * Récuperer le candidat associés a ce diplome
     */
    public function candidat(){
        return $this->belongsTo('App\Candidat');
    }

     /**
     * Récuperer la diplome associée a ce candidat
     */
    public function diplomeEcoles(){
        return $this->belongsTo('App\DiplomeEcole','diplome_ecole_id','id');
    }

    

}
