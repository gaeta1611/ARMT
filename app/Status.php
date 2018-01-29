<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Status extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'avancement',
       'status',
   ];

   /**
    * Le nom de la table 
    *
    * @var string
    */
   protected $table = 'status';

    /**
    * Récuperer les candidatures associés à ce status
    */
   public function candidatures (){
       return $this->hasMany('App\Candidature');
   }
   
}
