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


class AnnonceImage extends Resource
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
            'path' => $this->path,
            'name' => $this->name,
            'type' => $this->type,
            'size' => $this->size,
            'slug' => $this->slug,

            'created_at_human'=>$this->created_at_human,



            /**
             * Relation handling
             */
            'image_id' => new Image($this->getImage),
            'annonce_id' => new Annonce($this->annonce_id),


            /**
             * Timestamp
             */
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}