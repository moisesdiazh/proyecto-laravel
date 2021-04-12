<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //le indicamos que tabla modificara este modelo
    protected $table = 'comments'; 

    //Relacion de muchos a uno con el user

    public function user()
    {

        return $this->belongsTo('App\User', 'user_id');
    }

    //Relacion de muchos a uno con las images

    public function image()
    {

        return $this->belongsTo('App\Image', 'image_id');
    }
}
