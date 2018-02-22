<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'sexe',
        'localite_id',
        'telephone',
        'email',
        'linkedin',
        'site',
        'remarques',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'candidat';

    /**
     * Récuperer la localité associée au candidat
     */
    public function localite(){
        return $this->belongsTo('App\Localite');
    }

    /**
     * Récuperer les job description associés à cette mission
     */
    public function candidatures(){
        return $this->hasMany('App\Candidature');
    }

    /**
     * Récupere toute les langues du candidat
     */
    public function langues(){
        return $this->belongsToMany('App\Langue','candidat_langues','candidat_id','langue_id')
            ->withPivot('niveau');
    }
    
    /**
     * Récuperer les emplois associés à ce candidat
     */
    public function candidatSocietes(){
        return $this->hasMany('App\CandidatSociete');
    }

    /**
     * Récuperer tout les diplomes du candidat
     */
    public function diplomes(){
        return $this->belongsToMany('App\Diplome','candidat_diplomes','candidat_id','diplome_id')
           ->withPivot('ecole_id')->with('ecoles');
    }
}
