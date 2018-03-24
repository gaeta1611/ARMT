<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localite extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_postal',
        'localite',
    ]; 
    
    /**
     * Le nom de la table.
     *
     * @var string
     */
    protected $table = 'localites';
    
    /**
     * Gestion automatique des champs created_at et updated_at
     * 
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * Récupère les clients associés à la localité
     */
    public function client() {
        return $this->hasMany('App\Client');
    }

    /**
     * Récupère les candidats associés à la localité
     */
    public function candidat() {
        return $this->hasMany('App\Candidat');
    }
}
