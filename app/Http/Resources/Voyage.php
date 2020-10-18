<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Voyage
|
|
|
|*/


class Voyage extends Resource
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
            'date_depart'=>$this->date_depart,
            'description'=>$this->description,
            'nombre_place'=>$this->nombre_place,
            'moyen_transport'=>$this->moyen_transport,
            'etat'=>$this->etat,
            'image'=>$this->image_relation_ship,
            'slug'=>$this->slug,
            'promoteur' => $this->partenaire,

            'heure_depart'=>$this->heure_depart,
            'duree'=>$this->duree,
            'valider_par'=>$this->valider_par,
            'date_simple'=>$this->date_simple,
            'date_depart_human'=>$this->date_depart_human,
            'created_at_human'=>$this->created_at_human,
            'partenaire'=>$this->partenaire_relation_ship,
            'itineraire'=>$this->itineraire_relation_ship,
            'tarif' => $this->tarif_relation_ship,
        ];
    }


}
