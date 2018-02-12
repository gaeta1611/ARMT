<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'designation',
        'code_langue',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'langues';

    /**
     * Récupere les candidats associés a cette langue
     */
    public function candidats(){
        return $this->belongsToMany('App\Candidat','candidat_langues','candidat_id','langues_id');
    }
}
