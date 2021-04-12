<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images'; //le indicamos que tabla modificara este modelo

    //Relacion de uno a muchos

    public function comments()
    {
                                            //debemos colocar el order by para poder ordenar los comentarios
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    //Relacion de uno a muchos con los likes

    public function likes()
    {

        return $this->hasMany('App\Like');
    }

    // Relacion de muchos a uno

    public function user()
    {

        return $this->belongsTo('App\User', 'user_id');
    }
}
