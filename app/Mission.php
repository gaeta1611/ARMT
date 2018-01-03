<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'mission';
    
     /**
     * Récuperer les clients associés à la localité
     */
    public function client(){
        return $this->belongsTo('App\Client');
    }
}
