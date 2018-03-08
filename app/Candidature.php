<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mission_id',
        'candidat_id',
        'date_candidature',
        'postule_mission_id',
        'date_traitement',
        'status_id',
        'information_candidature_id',
        'mode_reponse_id',
        'date_reponse',
        'rapport_interview_id',
        'remarques',
        'mode_candidature_id',
        'created_at',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'candidature';

    /**
     * Récuperer la mission associée à la candidature
     */
    public function mission (){
        return $this->belongsTo('App\Mission');
    }

    /**
     * Récuperer les candidatures associé à ce candidat.
     */
    public function candidat(){
        return $this->belongsTo('App\Candidat');
    }

    /**
     * Récuperer le status de la candidature
     */
    public function status(){
        //Relation une candidature possède un et un seul status
        //candidature/status correspond à statust.id
        return $this->hasOne('App\Status','id','status_id');
    }

    /**
     * Récuperer le mode de candidature de la candidature
     */
    public function modeCandidature(){
        //Relation une candidature possède une et une seule ModeCandidature
        //Candidature.mode_candidature_id correspond à ModeCandidature.id
        return $this->hasOne('App\ModeCandidature','id','mode_candidature_id');
    }

    /**
     * Récuperer le niveau d'information de la candidature (on going,JD,...)
     */
    public function informationCandidature(){
        //Relation une candidature possède une et un seul niveau d'information
        //Candidature.information_candidature_id correspond à InformationCandidature.id
        return $this->hasOne('App\InformationCandidature','id','information_candidature_id');
    }

    /**
     * Récuperer le mode de réponse de la candidature (Tel EC,...)
     */
    public function modeReponse(){
        //Relation une candidature possède une et un seul mode de réponse
        //Candidature.mode_reponse_id correspond à ModeReponse.id
        return $this->hasOne('App\ModeReponse','id','mode_reponse_id');
    }

    /**
     * Récuperer les rapports d'interview associés à cette candidature
     */
    public function rapport(){
        return $this->hasOne('App\Document','id','rapport_interview_id');
    }

    /**
     * Récuperer les interviews associés à cette candidature
     */
    public function interviews(){
        return $this->hasMany('App\Interview');
    }

}
