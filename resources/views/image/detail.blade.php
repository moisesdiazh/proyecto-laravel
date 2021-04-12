@extends('layouts.app')

<!-- COPIO LA MISMA VISTA QUE TENEMOS EN EL HOME.BLADE Y LA MODIFICAMOS -->


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            @include('includes.message')
            <!-- mensaje de subido! -->

            <div class="card pub_image pub_image_detail">
                <div class="card-header">

                    @if($image->user->image)
                    <div class="container-avatar">
                        <!-- haciendo que se imprima por pantalla el avatar en la configuracion -->
                        <img src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" class="avatar" />
                        <!--se modifico aca-->
                        <!--esto lo sacamos de avatar.blade.php en includes-->
                    </div>
                    @endif
                    <div class="data-user">
                        {{$image->user->name.' '.$image->user->surname }}
                        <!--para que se vea el nombre y la descripcion-->

                        <span class="nickname">
                            <!--para que se vea el nick -->

                            {{' | @'.$image->user->nick }}
                        </span>
                    </div>
                </div>

                <div class="card-body">

                    <div class="image-container image-detail">
                        <!--aqui mostraremos las imagenes como tal con el getmage del imagecontroller-->
                        <img src="{{ route('image.file',['filename' =>$image->image_path]) }}" />


                    </div>

                    <div class="description">
                        <!--div para la descripcion -->

                        <span class="nickname">{{'@'.$image->user->nick }}</span>
                        <span class="nickname date">{{ ' | '.\FormatTime::LongTimeFilter($image->created_at) }} </span>
                        <!--FECHA -->
                        <p>{{ $image->description }}</p>
                    </div>

                    <div class="likes">
                        <!--div para los likes -->

                        <!--COMPROBAR SI EL USUARIO DIO LIKE A LA IMAGEN-->
                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                        @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true; ?>
                        @endif
                        @endforeach

                        @if($user_like)
                        <!--reflejando los likes-->
                        <img src="{{ asset('img/heartsazul.png') }}" data-id="{{ $image->id }}" class="btn-dislike" />
                        @else
                        <img src="{{ asset('img/heartsgris.png') }}" data-id="{{ $image->id }}" class="btn-like" />
                        @endif

                        <!--contador de los likes-->
                        <span class="number_likes">{{ count($image->likes) }}</span>

                    </div>
                    <!--condicion para verificar que es la persona quien quiere eliminar o actualizar-->
                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="actions">
                        <!--botones de actualizar y borrar-->
                        <a href="{{ route('image.edit', ['id' => $image->id ]) }}" class="btn btn-sm btn-primary">Update</a>
                        <!--                         <a href="{{ route('image.delete', ['id' => $image->id]) }}" class="btn btn-sm btn-danger">Delete</a>-->

                        <!--modal de boostrap que modificamos-->
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">
                            Delete
                        </button>

                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Are you sure?</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">

                                        If you delete this image you will not be able to recover it, are you sure to delete it?
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                                        <a href="{{ route('image.delete', ['id' => $image->id]) }}" class="btn btn-danger">Do you want to delete?</a>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    @endif

                    <div class="clearfix"></div> <!-- ES PARA LIMPIAR LOS FLOTADOS -->
                    <div class="comments">
                        <!-- botton de comentarios y numero de comentarios -->

                        <h4>Comentarios( {{ count($image->comments)}} ) </h4>
                        <hr>

                        <form method="POST" action="{{ route('comment.save') }}">
                            @csrf

                            <!-- hidden para guardar el id de la imagen -->
                            <input type="hidden" name="image_id" value="{{ $image->id }}" />

                            <p>

                                <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content"></textarea>

                                @if($errors->has('content'))
                                <!-- ALERTA SI TENEMOS ERROR AL SUBIR el comentario -->
                                <span class="invalid-feedback" role="alert">

                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                                @endif

                            </p>

                            <button type="submit" class="btn btn-success">

                                Comentar
                            </button>
                        </form>
                        @foreach($image->comments as $comment)
                        <!--lista de comentarios -->
                        <div class="comment"><br>

                            <!--nos copiamos el div de description y lo modificamos -->

                            <span class="nickname">{{'@'.$comment->user->nick }}</span>
                            <span class="nickname date">{{ ' | '.\FormatTime::LongTimeFilter($comment->created_at) }} </span>
                            <!--FECHA -->

                            <!--el if lo agarramos del mismo delete del commentcontroller y lo modificamos-->
                            <!--es la validacion para saber si es la persona quien quiere eliminar el comentario-->
                            <p>{{ $comment->content }}<br>


                                @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                <!-- boton de eliminar-->
                                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn btn-sm btn-danger">
                                    Eliminar
                                </a>
                                @endif

                            </p>
                        </div>
                        @endforeach

                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection