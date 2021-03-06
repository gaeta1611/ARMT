<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ecole extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_ecole',
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
    protected $table = 'ecoles';

    /**
     * Récuperer les diplomes délivrés par cette école
     */
    public function diplomes (){
        return $this->belongsToMany('App\Diplome','diplomes_ecoles','diplome_id','ecole_id');
    }
}
