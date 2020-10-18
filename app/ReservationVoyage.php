<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Reservation Voyage
|
|
|
|*/



class ReservationVoyage extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservationvoyages';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $guarded = [];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getVoyage()
    {
        return $this->belongsTo(Voyage::class,'voyage');
   }

   public function getBillet() {
        return $this->belongsTo(Billet::class, 'billet');
   }

    public function getClient()
    {
        return $this->belongsTo(Client::class);
   }

}
