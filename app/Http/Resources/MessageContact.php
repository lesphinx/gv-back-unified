<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Resource   MessageContact
|
|
|
|*/


class MessageContact extends Resource
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

        'nom'=>$this->nom,'email'=>$this->email,'telephone'=>$this->telephone,'message'=>$this->message,'slug'=>$this->slug
        
        ];
    }

     /* --Generated with ❤ by Slugger ---*/

}
