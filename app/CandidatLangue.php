<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidatLangue extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'candidat_id',
        'langue_id',
        'niveau',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'candidat_langues';

    /**
     * Gestion automatique des champs created_at et updated_at
     *
     * @var boolean
     */
    public $timestamps = false;
    
     /**
     * Récuperer le candidat associés a ce niveau langue
     */
    public function candidat(){
        return $this->belongsTo('App\Candidat');
    }

     /**
     * Récuperer la langue associée a ce niveau de langue
     */
    public function langue(){
        return $this->belongsTo('App\Langue');
    }

}
