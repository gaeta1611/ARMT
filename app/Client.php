<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom_entreprise',
        'personne_contact',
        'telephone',
        'email',
        'adresse',
        'localite',
        'site',
        'linkedin',
        'tva',
        'prospect',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'client';
}
