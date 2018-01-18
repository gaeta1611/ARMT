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
}
