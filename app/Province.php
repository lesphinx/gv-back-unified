<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Decoupage Un
|
|
|
|*/



class Province extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'provinces';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'pays',
        'slug'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getPays()
    {
        return $this->belongsTo(Pays::class,'pays');
    }



}
