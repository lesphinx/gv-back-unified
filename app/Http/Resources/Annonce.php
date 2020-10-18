<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Annonce
|
|
|
|*/


class Annonce extends Resource
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
            'titre' => $this->titre,
            'contenue' => $this->contenue,
            'contact' => $this->contact,
            'annonceur' => $this->annonceur,
            'dateDebut' => $this->dateDebut,
            'dateFin' => $this->dateFin,
            'prix' => $this->prix,
            'nombreCaratere' => $this->nombreCaratere,
            'etat' => $this->etat,
            'images' => $this->images,
            'date_validation' => Carbon::parse($this->date_validation)->format('d-m-y'),
            'slug' => $this->slug,

            'dateDebutHuman'=>$this->dateDebutHuman,
            'date_fin_human'=>$this->date_fin_human,
            'created_at_human'=>$this->created_at_human,



            /**
             * Relation handling
             */
            'transaction' => new Transaction($this->getTransaction),
            'type_annonce' => new TypeAnnonce($this->type_annonce),
            'position' => new PositionAnnonce($this->getPostion),
            'partenaire' => new Partenaire($this->getPartenaire),
            'valider_par' => new Personnel($this->getPersonnel),
            'image' => new Image($this->getImage),

            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}