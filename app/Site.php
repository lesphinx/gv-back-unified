<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Location
|
|
|
|*/



class Site extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sites';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'description',
        'slug',
        'province',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];



    public function images()
    {
        return $this->belongsToMany('App\Image', 'site_images', 'site', 'image');
    }

    public function getProvice()
    {
        return $this->belongsTo(Province::class, 'province','id');
    }



}
