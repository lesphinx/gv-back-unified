<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   TypeAnnonce
|
|
|
|*/



class TypeAnnonce extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'typeannonces';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle',
        'description',
        'positionId',
        'positions',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $appends = ['created_at_human'];
    function getCreatedAtHumanAttribute() {
        //return Carbon::parse($this->created_at)->diffForHumans();


        setlocale(LC_TIME, 'fr');
        $date = ucfirst(strftime('%d' , strtotime($this->created_at)));
        $date .= ucfirst(strftime(' %B %Y à %H:%M' , strtotime($this->created_at)));
        return $date;
    }

    public function positions()
    {
        return $this->belongsToMany('App\PositionAnnonce', 'tarifannonces', 'type_annonce', 'position')->withPivot([
            'prix_image',
            'nbre_caractere',
            'prix_caractere',
            'devise',

        ]);
    }



}
