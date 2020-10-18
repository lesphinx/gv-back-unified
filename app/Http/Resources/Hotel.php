<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Resource   Hotel
|
|
|
|*/


class Hotel extends Resource
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
           'nom'=>$this->nom,
           'description'=>$this->description,
           'classement'=>$this->classement,
           'adresse'=>$this->adresse,
           'telephone'=>$this->telephone,
           'sit_web'=>$this->sit_web,
           'email'=>$this->email,
           'partenaire'=>new Partenaire($this->getPartenaire),
           'ville'=>new Ville($this->getVille),
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
