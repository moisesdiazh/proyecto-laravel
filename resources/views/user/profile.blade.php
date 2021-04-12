@extends('layouts.app')

<!--lo copiamos del home.blade y modificamos-->
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="profile-user">

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

                    <h1>{{'@'.$user->nick }}</h1>
                    <!--mostrando el nick-->
                    <h2>{{ $user->name .' '. $user->surname }}</h2>
                    <p>{{ 'Created: '.\FormatTime::LongTimeFilter($user->created_at) }}</p>
                    <!--mostrando el nombre y apellido-->
                </div>

                <div class="clearfix">
                    <!--limpia los flotados, sirve para cuando haces float en css-->
                </div>
                <hr>
                
            </div>

            <div class="clearfix">
                <!--limpia los flotados, sirve para cuando haces float en css-->

            </div>

            @foreach($user->images as $image)

            @include('includes.image',['image'=>$image])
            @endforeach

        </div>

    </div>
</div>
@endsection