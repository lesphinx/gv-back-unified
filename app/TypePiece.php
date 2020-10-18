<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Client
|
|
|
|*/

 

class TypePiece extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'type_pieces';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $guarded = [];

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
