<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;


class UserController extends Controller
{

    public function __construct() //aplicamos esto para que no puedan acceder sin estar logueados
    { //lo sacamos del homecontroller
        $this->middleware('auth');
    }

    public function index($search = null)
    {

        if (!empty($search)) {

            $users = User::where('nick', 'LIKE', '%'.$search.'%')
                            ->orWhere('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('surname', 'LIKE', '%'.$search.'%')
                            ->orderBy('id', 'desc')
                            ->paginate(5);
        } else {

            $users = User::orderBy('id', 'desc')->paginate(5);
        }

        return view('user.index', [

            'users' => $users
        ]);
    }

    public function config()
    {

        return view('user.config');
    }

    public function update(Request $request)
    {
        //el controller para poder hacer el update del configuration profile

        //nos estamos trayendo el id
        //conseguimos el usuario identificado
        $user = \Auth::user();
        $id = $user->id;


        //validamos el formulario en base a la request
        $validate = $this->validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id
        ]);


        //recogemos los datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        //asignar nuevos al objeto de usuario

        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //subir la imagen del avatar
        $image_path = $request->file('image_path'); //se debe colocar el use storage arriba
        if ($image_path) {

            // se pone un nombre unico
            $image_path_name = time() . $image_path->getClientOriginalName();


            //se guarda en la carpeta storage /app/users
            Storage::disk('users')->put($image_path_name, File::get($image_path)); //se debe cargar use file arriba
            //este metodo extrae la imagen de la carpeta temporal donde se encuentra guardado

            //seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        //ejecutamos la consulta y cambios en la base de datos

        $user->update();
        //esto es una con un mensaje
        return redirect()->route('config')->with(['message' => 'Updated']);
    }

    public function getImage($filename)
    {

        $file = Storage::disk('users')->get($filename);

        return new Response($file, 200); //debemos colocar el use responde arriba

        //se debe modificar la ruta y luego ir al config.blade y hacer la condicion para que se muestre la imagen
    }

    public function profile($id)
    {

        $user = User::find($id);

        return view('user.profile', [

            'user' => $user
        ]);
    }
}
