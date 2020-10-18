<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Model   Article
|
|
|
|*/


class Article extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['titre', 'contenu', 'slug', 'categorie', 'etat', 'user'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function getCategorieArticle()
    {
        return $this->belongsTo(CategorieArticle::class, 'categorie','id');
    }




    public function getAutheur()
    {
        return $this->belongsTo(Personnel::class, 'user','id');
    }

    public function getImage()
    {
        return $this->belongsToMany(Image::class, '');
    }

    public function getLike()
    {
        return $this->hasMany(Like::class, 'slug', 'liked_item');
    }

    public function getCommentaire()
    {
        return $this->hasMany(Commentaire::class, 'article');
    }

    public function getNote()
    {
        return $this->hasMany(Note::class, 'slug', 'liked_item');
    }
    public function getShare()
    {
        return $this->hasMany(Share::class, 'slug', 'liked_item');
    }
}
