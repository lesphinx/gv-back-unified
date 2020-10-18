<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationImage extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'location_images';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['image','location','slug'];

    protected $dates = ['deleted_at'];



}
