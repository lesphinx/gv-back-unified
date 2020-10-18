<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Location
|
|
|
|*/



class Location extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'description',
        'date_debut_disponibilite',
        'slug', 'ville',
        'date_fin_disponibilite',
        'etat',
        'valider_par',
        'partenaire',
        'prix_jour'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $appends = ['date_debut_human', 'date_fin_human', 'human_created_at' ];

    function getDateDebutHumanAttribute() {
        setlocale(LC_TIME, 'fr');
        $new_date = $this->date_debut_disponibilite;
        $date = ucfirst(strftime('%d' , strtotime($new_date)));
        $date .= ucfirst(strftime(' %B %Y' , strtotime($new_date)));

        return $date;
    }

    function getHumanCreatedAtAttribute() {
        setlocale(LC_TIME, 'fr');
        $new_date = $this->created_at;
        $date = ucfirst(strftime('%d' , strtotime($new_date)));
        $date .= ucfirst(strftime(' %B %Y' , strtotime($new_date)));

        return $date;
    }

    function getDateFinHumanAttribute() {
        //return Carbon::parse($this->created_at)->diffForHumans();
        setlocale(LC_TIME, 'fr');
        $new_date = $this->date_fin_disponibilite;
        $date = ucfirst(strftime('%d' , strtotime($new_date)));
        $date .= ucfirst(strftime(' %B %Y' , strtotime($new_date)));

        return $date;
    }

    public function images()
    {
        return $this->belongsToMany('App\Image', 'location_images', 'location', 'image');
    }

    public function getPartenaire()
    {
        return $this->belongsTo(Partenaire::class,'partenaire');
    }


    public function getValiderPar()
    {
        return $this->belongsTo(Personnel::class,'valider_par');
    }

    public function getVille() {
        return $this->belongsTo(Ville::class, 'ville');
    }
}
