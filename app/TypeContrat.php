<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeContrat extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tpye',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'type_contrat';

     /**
     * Récuperer les missions associés au type de contrat
     */
    public function mission (){
        return $this->hasMany('App\Mission');
    }
    
}
