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



class Annonce extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'annonces';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [


        'titre',
        'contenue',
        'contact',
        'annonceur',
        'dateDebut',
        'dateFin',
        'prix',
        'slug',
        'nombreCaratere',
        'position',
        'etat',
        'images',
        'date_validation',
        'utilisateur',
        'partenaire',
        'valider_par'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];



    protected $appends = ['dateDebutHuman', 'created_at_human' ,'date_fin_human'];

    function getDateDebutHumanAttribute() {
        setlocale(LC_TIME, 'fr');
        $new_date = $this->dateDebut;
        $date = ucfirst(strftime('%A , %d' , strtotime($new_date)));
        $date .= ucfirst(strftime(' %B' , strtotime($new_date)));

        return $date;
    }
    function getDateFinHumanAttribute() {
        //return Carbon::parse($this->created_at)->diffForHumans();
        setlocale(LC_TIME, 'fr');
        $new_date = $this->dateFin;
        $date = ucfirst(strftime('%A , %d' , strtotime($new_date)));
        $date .= ucfirst(strftime(' %B ' , strtotime($new_date)));

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



    public function transaction_relation_ship()
    {
        return $this->hasOne(Transaction::class,'transaction');
    }

    public function utilisateur_relation_ship()
    {
        return $this->belongsTo(Utilisateur::class,'utilisateur');
    }


    public function images()
    {
        return $this->belongsToMany('App\Image', 'annonceimages', 'annonce', 'image');
    }

    public function position_annonce_relation_ship()
    {
        return $this->belongsTo(PositionAnnonce::class,'position');
    }


}
