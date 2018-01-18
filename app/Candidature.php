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
        'date_traitement',
        'status',
        'information_candidat',
        'mode_reponse',
        'date_reponse',
        'date_F2F',
        'date_rencontre_client',
        'rapport_interview',
        'remarques',
        'mode_candidature',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'candidature';
}
