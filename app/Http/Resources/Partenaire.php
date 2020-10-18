<?php

namespace App\Http\Resources;

use App\Http\Controllers\FileUpLoad;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Partenaire
|
|
|
|*/


class Partenaire extends Resource
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
            'nom'=>$this->nom_partenaire,
            'adresse'=>$this->adresse,
            'numero_tel' => $this->numero_tel,
            'description'=>$this->description,
            'site_web'=>$this->site_web,
            'logo' => $this->logo,
            'etat'=>$this->etat,
            'type' => $this->type_partenaire,
            'slug'=>$this->slug,
            'is_actived' => $this->is_actived,
            /**
             * Relation handling
             */
            'agence_principale'=>$this->getAgencePrincipale,
            'agences' => $this->getAgence,
            'location' => $this->getLocation,
            'voyage' => $this->getVoyage,
            'pieces' => $this->getPieceJointe,
            'annonce' => $this->getAnnonce,
            'user' => $this->getUser,

            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),


        ];
    }


}
