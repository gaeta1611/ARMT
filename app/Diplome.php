<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diplome extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_diplome',
        'designation',
        'finalite',
        'niveau',
    ];

    /**
     * Gestion automatique des champs automatique created_at et updated_at
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'diplomes';

    /**
     * Récuperer l'ecole associés à ce diplome
     */
    public function ecoles (){
        return $this->belongsToMany('App\Ecole','diplomes_ecoles','diplome_id','ecole_id');
    }
}
