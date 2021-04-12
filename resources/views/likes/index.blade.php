@extends('layouts.app')

<!--agarramos todo del home.blade y lo modificamos-->
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>Likes</h1>

            <hr>

            @foreach($likes as $like)

            @include('includes.image',['image'=>$like->image])

            @endforeach

            <div class="clearfix"></div>
            <!--paginacion para poder pasar a las otras paginas-->

            {{ $likes->links() }}

        </div>

    </div>
</div>
@endsection