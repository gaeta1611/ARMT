<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformationCandidature extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'information',
   ];

   /**
    * Le nom de la table 
    *
    * @var string
    */
   protected $table = 'information_candidature';

    /**
    * Récuperer les candidatures associés à ce niveau d'information
    */
   public function candidatures (){
       return $this->hasMany('App\Candidature');
   }
   
   
}
