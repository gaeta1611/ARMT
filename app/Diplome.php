<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diplome extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'designation',
        'niveau',
    ];

    /**
     * Le nom de la table 
     *
     * @var string
     */
    protected $table = 'diplomes';
}
