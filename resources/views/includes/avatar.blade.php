@if(Auth::user()->image)

<div class="container-avatar">
    <!-- haciendo que se imprima por pantalla el avatar en la configuracion -->
    <img src="{{ route('user.avatar',['filename' => Auth::user()->image]) }}" class="avatar" />

</div>
@endif