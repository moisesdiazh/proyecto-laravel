<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct() //aplicamos esto para que no puedan acceder sin estar logueados
    { //lo sacamos del homecontroller
        $this->middleware('auth');
    }

    public function save(Request $request)
    {

        //validacion
        $validate = $this->validate($request, [

            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);

        //recoger datos
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //debemos importar el use comment arriba

        //asigno los valores a mi nuevo objeto a guardar
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //guardar en la bd
        $comment->save();

        //redireccion
        return redirect()->route('image.detail', ['id' => $image_id])
            ->with([

                'message' => 'Has publicado tu comentario correctamente!'
            ]);
    }

    public function delete($id)
    { //eliminar comentarios

        //conseguir datos del usuario logueado
        $user = \Auth::user();

        //conseguir el objeto del comentario
        $comment = Comment::find($id);

        //comprobar si soy el dueño del comentario o de la publicacion
        if ($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)) {

            $comment->delete();

            return redirect()->route('image.detail', ['id' => $comment->image->id])
                ->with([

                    'message' => 'Sended!'
                ]);
        } else {


            return redirect()->route('image.detail', ['id' => $comment->image->id])
                ->with([

                    'message' => 'Failed!'
                ]);
        }
    }
}
