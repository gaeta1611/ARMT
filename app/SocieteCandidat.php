<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocieteCandidat extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'url_document',
        'filename',
        'candidat_id',
        'mission_id',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'societe_candidat';
    
     /**
     * Récuperer la sciété associés a cet emploi
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
