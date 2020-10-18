<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteImage extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'site_images';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['image','site','slug'];

    protected $dates = ['deleted_at'];



}
