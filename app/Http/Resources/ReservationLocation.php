<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   ReservationLocation
|
|
|
|*/


class ReservationLocation extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date_reservation'=>$this->date_reservation,
            'date_validation'=>$this->date_validation,
            'statut'=>$this->statut,
            'date_debut'=>$this->date_debut,
            'prix_location'=>$this->prix_location,
            'date_fin'=>$this->date_fin,
            'slug'=>$this->slug,
             /**
              *
              */
            'location'=>new Location($this->getLocation),
           // 'note'=>$this->note,
            'client'=>new Client($this->getClient)
        ];
    }


}
