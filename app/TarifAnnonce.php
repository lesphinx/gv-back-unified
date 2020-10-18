<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   TarifAnnonce
|
|
|
|*/



class TarifAnnonce extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tarifannonces';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prix_image',
        'prix_caractere',
        'position',
        'type_annonce',
        'nbre_caractere',
        'devise',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $appends = [ 'created_at_human' ];
    function getCreatedAtHumanAttribute() {
        //return Carbon::parse($this->created_at)->diffForHumans();


        setlocale(LC_TIME, 'fr');
        $date = ucfirst(strftime('%d' , strtotime($this->created_at)));
        $date .= ucfirst(strftime(' %B %Y à %H:%M' , strtotime($this->created_at)));
        return $date;
    }


}
