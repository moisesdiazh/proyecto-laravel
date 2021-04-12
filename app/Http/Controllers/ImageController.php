<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Comment;
use App\Like;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{


    public function __construct() //aplicamos esto para que no puedan acceder sin estar logueados
    { //lo sacamos del homecontroller
        $this->middleware('auth');
    }

    public function create()
    {

        return view('image.create');
    }

    public function save(Request $request)
    {

        //validacion
        $validate = $this->validate($request, [

            'description' => 'required',
            'image_path'  => 'required|mimes:jpg,jpeg,png,gif'
        ]);

        //recogiendo los datos
        $image_path = $request->file('image_path');
        //con dicha variable accedemos al archivo que queremos subir mediante el formulario
        $description = $request->input('description');

        //asignar valores al nuevo objeto, tenemos que colocar el use\app\image arriba
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

        //subir fichero
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            //busca que tenga un nombre unico
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            //guardando la imagen

            $image->image_path = $image_path_name;
        }

        $image->save(); //el insert en la base de datos para guardar

        return redirect()->route('home')->with([

            'message' => '¡Uploaded!'
        ]);
    }

    //metodo que me devuelve las imagenes
    public function getImage($filename)
    {

        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    //funcion para sacar el detalle de la imagen
    public function detail($id)
    {

        $image = Image::find($id);

        return view('image.detail', [

            'image' => $image
        ]);
    }

    public function delete($id)
    {

        $user = \Auth::user(); //buscamos el id del usuario identificado
        $image = Image::find($id); //conseguimos el objeto de la imagen

        //sacamos los comentarios y likes asociados a la imagen
        //debemos cargar los modelos arriba de Comment y Like
        //cuando imageid = id, get para sacar todos los registros
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        //hacemos la condicion para que reconozca solo al dueño de los comentarios, like, etc
        if ($user && $image && $image->user->id) {

            //eliminar comentarios
            if ($comments && count($comments) >= 1) {

                foreach ($comments as $comment) {

                    $comment->delete();
                }
            }

            //eliminar likes
            if ($likes && count($likes) >= 1) {

                foreach ($likes as $like) {

                    $like->delete();
                }
            }

            //eliminar fichero de imagen
            Storage::disk('images')->delete($image->image_path);

            //eliminar registro imagen
            $image->delete();

            $message = array('message' => '¡La imagen ha sido borrada!');
        } else {

            $message = array('message' => '¡La imagen no se ha borrado correctamente!');
        }

        return redirect()->route('home')->with($message);
    } //para finalizar debemos añadir la ruta y luego colocamos la ruta en la vista detail en los botones de update y delete

    public function edit($id)
    {

        $user = \Auth::user(); //sacamos el usuario identificado

        $image = Image::find($id); //sacamos el objeto de la imagen

        //es igual al usuario identificado
        if ($user && $image && $image->user->id == $user->id) {

            return view('image.edit', [

                'image' => $image
            ]);
        } else {

            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {

        //validacion, se agarra del save que esta arriba
        $validate = $this->validate($request, [

            'description' => 'required',
            'image_path'  => 'mimes:jpg,jpeg,png,gif'
        ]);

        //recogemos los datos
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //conseguir objeto image
        $image = Image::find($image_id);
        $image->description = $description;



        //subir foto
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            //busca que tenga un nombre unico
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            //guardando la imagen

            $image->image_path = $image_path_name;
        }

        //actualizar registro
        $image->update();

        return redirect()->route('image.detail', [ 'id' => $image_id ])
                         ->with(['message' => 'Updated!']);
    }
}
