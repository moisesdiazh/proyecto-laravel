@extends('layouts.app')
<!--todo lo traemos del home.blade-->
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>People</h1>

            <!--formulario de busqueda en people-->
            <form method="GET" action="{{ route('user.index') }}" id="buscador">
            <div class="row">
                <div class="form-group col">

                    <input type="text" id="search" class="form-control" />
                </div>

                <div class="form-group col btn-search">
                    <input type="submit" value="Search" class="btn btn-success" />
                </div>
            </div>

            <!-- fin de formulario de busqueda en people-->
            <!--luego modificaremos en el main.js la url-->
            </form> 

            <hr>
            @foreach($users as $user)

            <div class="profile-user">
                <!--este div lo sacamos de profile.blade-->

                @if($user->image)
                <!--lo sacamos del image.blade-->
                <div class="container-avatar">
                    <!-- haciendo que se imprima por pantalla el avatar en la configuracion -->
                    <img src="{{ route('user.avatar',['filename'=>$user->image]) }}" class="avatar" />
                    <!--se modifico aca-->
                    <!--esto lo sacamos de avatar.blade.php en includes-->
                </div>
                @endif


                <div class="user-info">

                    <h2>{{'@'.$user->nick }}</h2>
                    <!--mostrando el nick-->
                    <h3>{{ $user->name .' '. $user->surname }}</h3>
                    <p>{{ 'Created: '.\FormatTime::LongTimeFilter($user->created_at) }}</p>
                    <!--mostrando el nombre y apellido y la fecha de cuando se creo la cuenta-->

                    <a href="{{ route('profile', ['id' => $user->id]) }}" class="btn btn-success">Profile</a>
                </div>

                <div class="clearfix">
                    <!--limpia los flotados, sirve para cuando haces float en css-->
                </div>
                <hr>

            </div>
            @endforeach

            <!--luego debemos añadir el boton en app.blade al lado de likes para que se pueda ver en el home-->

            <div class="clearfix"></div>
            <!--paginacion para poder pasar a las otras paginas-->

            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection