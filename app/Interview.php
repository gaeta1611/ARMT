<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'candidature_id',
        'type',
        'date_interview',
        
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'interviews';

    /**
     * Gestion automatique des champs automatique created_at et updated_at
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Récuperer la candidature associée à cette interview
     */
    public function candidature (){
        return $this->belongsTo('App\Candidature');
    }
}
