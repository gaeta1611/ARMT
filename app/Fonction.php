<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fonction',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'fonctions';

    /**
     * Gestion automatique des champs automatique created_at et updated_at
     *
     * @var boolean
     */
    public $timestamps = false;

     /**
     * Récuperer la mission associés a cette fonction
     */
    public function mission(){
        return $this->belongsTo('App\Mission');
    }
}
