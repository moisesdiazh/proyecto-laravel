@if(session('message'))
<!-- MENSAJE INDICANDO QUE HA SIDO ACTUALIZADO EL USER -->
<div class="alert alert-success">

    {{session('message')}}
</div>
@endif