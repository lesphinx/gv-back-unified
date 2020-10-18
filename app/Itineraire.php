<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Itineraire
|
|
|
|*/



class Itineraire extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'itineraires';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ville_depart',
        'ville_arrivee',
        'description',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getVilleArrivee()
    {
        return $this->belongsTo(Ville::class,'ville_arrivee');
    }

    public function getVilleDepart()
    {
        return $this->belongsTo(Ville::class,'ville_depart');

    }

    public function getVilleItineraire() {
        return $this->hasMany(VilleItineraire::class, 'itineraire')
            ->orderBy('rang');
    }



}
