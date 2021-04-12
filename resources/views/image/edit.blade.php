@extends('layouts.app')
<!-- heredamos el layouts, lo agarramos de register todo-->
@section('content')

<!-- se copia el mismo formato de create.blade -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">

                <div class="card-header">Edit photo</div>


                <div class="card-body">

                    <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="image_id" value="{{ $image->id }}" />
                        <!--el input hidden se aplica solamente cuando es request la function para recibir el id-->

                        <div class="form-group row">

                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Image</label>
                            <div class="col-md-7">

                                @if($image->user->image)
                                <div class="container-avatar"> 
                                    <!-- haciendo que se imprima por pantalla el avatar en la configuracion -->
                                    <img src="{{ route('image.file',['filename' =>$image->image_path]) }}" class="avatar" /><!--esto se trajo de detail.blade-->
                                    <!--se modifico aca-->
                                    <!--esto lo sacamos de avatar.blade.php en includes-->
                                </div>
                                @endif

                                <input id="image_path" type="file" name="image_path" class="form-control {{ $errors->has('image_path') ? 'is-invalid' : '' }}" />

                                @if($errors->has('image_path'))
                                <!-- ALERTA SI TENEMOS ERROR AL SUBIR LA IMAGEN -->
                                <span class="invalid-feedback" role="alert">

                                    <strong>{{ $errors->first('image_path') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
                            <div class="col-md-7">
                                <textarea id="description" name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" required>{{ $image->description }}</textarea>

                                @if($errors->has('description'))
                                <!-- ALERTA SI TENEMOS ERROR AL SUBIR LA IMAGEN -->
                                <span class="invalid-feedback" role="alert">

                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-6 offset-md-3">
                                <input type="submit" class="btn btn-primary" value="Update" />


                            </div>
                        </div>



                    </form>

                </div>

            </div>
        </div>
    </div>
</div>



@endsection

<!--  termino del section con el contenido -->