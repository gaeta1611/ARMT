<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidatSociete extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'candidat_id',
        'societe_id',
        'fonction_id',
        'societe_actuelle',
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
    protected $table = 'societe_candidat';
    
     /**
     * Récuperer la société associés a cet emploi
     */
    public function societe(){
        return $this->belongsTo('App\Societe');
    }

     /**
     * Récuperer le candidat  associés a cet emploi
     */
    public function candidat(){
        return $this->belongsTo('App\Candidat');
    }

     /**
     * Récuperer la fonction  associés a cet emploi
     */
    public function fonction(){
        return $this->belongsTo('App\Fonction');
    }
}
