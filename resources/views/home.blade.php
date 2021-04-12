@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('includes.message')
            <!-- mensaje de subido! -->
            @foreach($images as $image)

            @include('includes.image',['image'=>$image])
            @endforeach
            <div class="clearfix"></div>
            <!--paginacion para poder pasar a las otras paginas-->

            {{ $images->links() }}
        </div>
    </div>

</div>
</div>
@endsection