<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   TarifAnnonce
|
|
|
|*/


class TarifAnnonce extends Resource
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

            'prix_caractere' => $this->prix_caractere,
          'nbre_caractere' => $this->nbre_caractere,
          'devise' => $this->devise,
          'prix_image' =>$this->prix_image,
          'position' => $this->position,
          'type_annonce' =>$this->type_annonce,
          
          'created_at_human'=>$this->created_at_human,
       
        'slug'=>$this->slug,

        'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y'),

        ];
    }


}
