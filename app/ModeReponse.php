<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeReponse extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'media',
       'description',
   ];

   /**
    * Le nom de la table 
    *
    * @var string
    */
   protected $table = 'mode_reponse';

    /**
    * Récuperer les candidatures associés à ce niveau d'information
    */
   public function candidatures (){
       return $this->hasMany('App\Candidature');
   }
   
   
}
