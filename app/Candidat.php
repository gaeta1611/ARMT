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
        'localite',
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
        return $this->belongsToMany('App\Langue','candidat_langues','candidat_id','langues_id');
    }
    
    /**
     * Récuperer les emplois associés à ce candidat
     */
    public function societeCandidats(){
        return $this->hasMany('App\SocieteCandidats');
    }
}
