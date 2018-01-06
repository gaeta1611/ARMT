<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'url_document',
        'filename',
        'candidat_id',
        'mission_id',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'documents';
    
     /**
     * Récuperer la mission associés au document
     */
    public function mission(){
        return $this->belongsTo('App\Mission');
    }

     /**
     * Récuperer le candidat  associés au document
     */
    public function candidat(){
        return $this->belongsTo('App\Candidat');
    }

}
