<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeCandidature extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'media',
   ];

   /**
    * Le nom de la table 
    *
    * @var string
    */
   protected $table = 'mode_candidature';

   /**
    * Champ mode_candidature.media décomposé en deux champs distincts
    *
    * @var array Champs virtuels
    */
   protected $appends = ['type','mode'];

   /**
    * 
    * @return string Type relatif au mode de candidature (email, par chasse,...)
    */
   public function getTypeAttribute()
   {
       return json_decode($this->attributes['media'])->type;
   }

   /**
    * 
    * @return string Détail du mode de candidature (spontanément, StepStone,...)
    */
    public function getModeAttribute()
    {
        return json_decode($this->attributes['media'])->mode;
    }

    /**
    * 
    * Modifie la partie type du champ mode_candidature.media
    */
   public function setTypeAttribute($type)
   {
       $media = json_decode($this->attributes['media']);
       $media->type = $type;
       $this->attributes['media'] = json_encode($media);
   }

   /**
    * 
    * Modifie la partie mode du champ mode_candidature.media
    */
    public function setModeAttribute($mode)
    {
        $media = json_decode($this->attributes['mode']);
        $media->type = $type;
        $this->attributes['mode'] = json_encode($mode);
    }



    /**
    * Récuperer les candidatures associés à ce mode de candidature
    */
   public function candidatures (){
       return $this->hasMany('App\Candidature');
   }


   
}
