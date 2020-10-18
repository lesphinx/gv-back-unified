<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Hotel
|
|
|
|*/



class Hotel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hotels';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'description', 'classement', 'adresse', 'telephone', 'sit_web', 'email', 'partenaire', 'ville', 'slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getVille()
    {
      return $this->belongsTo(Ville::class,'ville','id');
    }

    public function getPartenaire()
    {
      return $this->belongsTo(Partenaire::class,'partenaire','id');
    }

    public function getChambre()
    {
      return $this->hasMany(Chambre::class,'id','hotel');
    }

 /* --Generated with ❤ by Slugger ---*/


}
