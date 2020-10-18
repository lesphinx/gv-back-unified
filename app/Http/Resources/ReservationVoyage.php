<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   ReservationVoyage
|
|
|
|*/


class ReservationVoyage extends Resource
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
        'dateVoyage'=>$this->dateVoyage,
        'statut'=>$this->statut,
        'nom_voyageur'=>$this->nom_voyageur,
        'prenom_voyageur'=>$this->prenom_voyageur,
        'slug'=>$this->slug,
        'prix_voyage' => $this->prix_voyage,
        'age_voyageur' => $this->age_voyageur,
        'type_piece' => $this->type_piece,
        'numero_piece' => $this->numero_piece,
        'voyage' => new Voyage($this->getVoyage),
        'client' => new Client($this->getClient),
        'billet' => new Billet($this->getBillet)
        ];
    }


}
