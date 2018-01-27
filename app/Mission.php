<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'fonction',
        'type_contrat_id',
        'status',
        'remarques',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'mission';
    
     /**
     * Récuperer les clients associés à cette mission
     */
    public function client(){
        return $this->belongsTo('App\Client');
    }

    /**
     * Récuperer les types de contrats  associés à la mission
     */
    public function typeContrat (){
        return $this->belongsTo('App\TypeContrat');
    }

    /**
     * Récuperer le contrat associés à cette mission
     */
    public function contrat(){
        //Relation une mission possède un et un seul contrat
        //Mission.contrat_id correspond à document.id
        return $this->hasOne('App\Document','id','contrat_id');
    }

    /**
    * Récuperer les job description associés à cette mission
    */
    public function job_descriptions(){
        return $this->hasMany('App\Document')->where(['type'=>'Job description']);
    }

    /**
    * Récuperer les offres associés à cette mission
    */
    public function offres(){
        return $this->hasMany('App\Document')->where(['type'=>'Offre']);
    }

    /**
     * Récuperer les candidatures associés à cette mission
     */
    public function candidatures(){
        return $this->hasMany('App\Candidature');
    }

    // Query scopes: list des méthodes partagées
    /**
     * @param type $query
     */
    public function scopeOngoingMissions($query){
        return $query->where(['status'=>'En cours'])->get();
    }

}
