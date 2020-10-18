<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Voyage
|
|
|
|*/



class Voyage extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'voyages';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero',
        'date_depart',
        'description',
        'nombre_place',
        'moyen_transport',
        'slug',
        'etat',
        'itineraire',
        'image',
        'duree', 'heure_depart',
        'partenaire',
        'valider_par'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];



   /* public function getItineraire()
    {
        return $this->hasMany(Itineraire::class,'');
    }
*/

    protected $appends = ['date_depart_human', 'created_at_human', 'date_simple' ];

    function getDateDepartHumanAttribute() {
        setlocale(LC_TIME, 'fr');
        $new_date = $this->date_depart;
        $date = ucfirst(strftime('%A , %d' , strtotime($new_date)));
        $date .= ucfirst(strftime(' %B %Y' , strtotime($new_date)));
        $date .= ucfirst(strftime(' à %H:%M' , strtotime($this->heure_depart)));

        return $date;
    }

    function getDateSimpleAttribute() {
        setlocale(LC_TIME, 'fr');
        $new_date = $this->date_depart;
        $date = ucfirst(strftime('%A , %d' , strtotime($new_date)));
        $date .= ucfirst(strftime(' %B %Y' , strtotime($new_date)));

        return $date;
    }


    function getCreatedAtHumanAttribute() {
        //return Carbon::parse($this->created_at)->diffForHumans();


        setlocale(LC_TIME, 'fr');
        $date = ucfirst(strftime('%d' , strtotime($this->created_at)));
        $date .= ucfirst(strftime(' %B %Y à %H:%M' , strtotime($this->created_at)));
        return $date;
    }

    public function itineraire_relation_ship() {
        return $this->belongsTo(Itineraire::class, 'itineraire');
    }

    public function partenaire_relation_ship() {
        return $this->belongsTo(Partenaire::class, 'partenaire')->select('nom_partenaire', 'slug');
    }

    public function tarif_relation_ship() {
        return $this->hasMany(ClasseVoyage::class , 'voyage');
    }

    public function getValiderPar()
    {
        return $this->belongsTo(Personnel::class,'valider_par');
    }

    public function image_relation_ship()
    {
        return $this->belongsTo(Image::class,'image');
    }
}
