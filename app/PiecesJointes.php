<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PiecesJointes extends Model
{
     /**
      *
      */
     protected  $table = 'pieces_jointes';

     protected $fillable = ['url_file' , 'slug' , 'owner'];

     protected  $dates = ['deleted_at'];


}
