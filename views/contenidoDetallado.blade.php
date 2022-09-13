@extends('app')
@section('content')
<form action="index.php" method="post">
    <input type="submit" value="Cerrar sesion" name="cerrarSesion"/>
    <input type="submit" value="Volver atras" name="volver"/>
</form>

<h2>{{$titulo}} ({{$año}})</h2>
<img src="img/{{$img}}" alt="{{$titulo}}" width="500" height="300" id="foto"/>
<p>Autor: {{$pintor}}</p>
<p>Epoca: {{$epoca}}</p>
<p>{{$descripcion}}</p>
    
@endsection