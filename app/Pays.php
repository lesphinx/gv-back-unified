<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Pay
|
|
|
|*/


class Pays extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pays';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso',
        'nom',
        'numcode',
        'nicename',
        'iso3',
        'capitale',
        'phonecode'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getDeoupageUn()
    {
        return $this->hasMany(DecoupageUn::class, 'pays','id');
    }

    public function getVille()
    {
        return $this->hasMany(Ville::class, 'pays','id');
    }
}
