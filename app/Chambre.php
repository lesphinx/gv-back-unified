<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Chambre
|
|
|
|*/



class Chambre extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chambres';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['numero', 'disponibilité', 'prix', 'type_chambre', 'hotel', 'description', 'slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

 /* --Generated with ❤ by Slugger ---*/


  public function getTypeChambre()
  {
    return $this->belongsTo(TypeChambre::class,'type_chambre','id');
  }

   public function getHotel()
   {
     return $this->belongsTo(Hotel::class,'hotel','id');

   }



}
