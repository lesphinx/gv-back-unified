<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Annonce
|
|
|
|*/



class AnnonceImage extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'annonceimages';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [


        'desc',
        'image',
        'annonce',
        'slug',

    ];

    use SoftDeletes;








    public function annonce_image_relation_ship()
    {
        return $this->hasOne(Annonce::class,'annonce');
    }




}
