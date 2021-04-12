<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// use App\Image;
// use Spipu\Html2Pdf\Tag\Html\Strong; 

// use Illuminate\Routing\Route;

use Illuminate\Support\Facades\Route;

Route::get('/', function () { 


    
    //  /* PROBANDO ORM */
    //  $images = Image::all();
    //  foreach ($images as $image) { 
    //     /* ESTAMOS REFLEJANDO LAS IMAGENES COMO SI FUERAN CONSULTAS*/
    //     echo $image->image_path . "<br/>";
    //     echo $image->description . "<br/>";
    //     echo $image->user->name . ' ' . $image->user->surname."<br/>";
    //     /* ES SIMILAR A UN INNER JOIN PERO MAS RESUMIDO */

    //     echo 'Likes: ' . count($image->likes);
    //     /*MOSTRANDO LOS LIKES COMO SI FUERA CONSULTA */
        
    //     if (count($image->comments) >= 1) { 
    //         /* ESTAMOS REFLEJANDO LOS COMENTARIOS COMO SI FUERAN CONSULTAS*/
    //         echo '<h4>Comentarios</h4>';
    //         foreach ($image->comments as $comment) {

    //             echo $comment->user->name . ' ' . $comment->user->surname . ': ';
    //             echo $comment->content . '<br/>';
    //         }
    //     }


    //     echo "<hr/>";
    // }
    // die(); 

    
    return view('welcome');
});

//RUTAS GENERALES
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

//rutas USUARIO
Route::get('/configuracion', 'UserController@config')->name('config');

Route::post('/user/update', 'UserController@update')->name('user.update');

Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');

Route::get('/profile/{id}', 'UserController@profile')->name('profile');

Route::get('/gente/{search?}', 'UserController@index')->name('user.index');

//Route::get('/people/{search?}', 'UserController@index')->name('user.index');


//RUTAS IMAGEN
Route::get('/upload-image/', 'ImageController@create')->name('image.create');

Route::post('/image/save', 'ImageController@save')->name('image.save');

Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');

Route::get('/image/{id}', 'ImageController@detail')->name('image.detail');

Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');

Route::get('/image/editar/{id}', 'ImageController@edit')->name('image.edit');

Route::post('/image/update', 'ImageController@update')->name('image.update');


//RUTAS COMENTARIOS
Route::post('/comment/save', 'CommentController@save')->name('comment.save');

Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');


//RUTAS LIKES
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');

Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');

Route::get('/likes', 'LikeController@index')->name('likes');
















