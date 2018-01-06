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
        'job_description_id',
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
}
