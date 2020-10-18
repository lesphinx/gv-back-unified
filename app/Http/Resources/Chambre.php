<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Chambre
|
|
|
|*/


class Chambre extends Resource
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
           'id'=>$this->id,
           'numero'=>$this->numero,
           'disponibilité'=>$this->disponibilité,
           'prix'=>$this->prix,
           'type_chambre'=>new TypeChambre($this->getTypeChambre),
           'hotel'=>new Hotel($this->getHotel),
           'description'=>$this->description,
           'slug'=>$this->slug,
           /**
            * Timestamp
            */
          'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
          'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),


        ];
    }

     /* --Generated with ❤ by Slugger ---*/

}
