<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes'; //le indicamos que tabla modificara este modelo


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
