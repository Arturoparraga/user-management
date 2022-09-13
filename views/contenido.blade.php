@extends('app')
@section('content')
<form action="index.php" method="POST" id="contenido">
    <input type="submit" value="Cerrar sesion" name="cerrarSesion"/>
    <input type="submit" value="Cambiar datos" name="irCambiarDatos"/>
    <input type="submit" value="Borrar Cuenta" name="borrar"/>
</form>
<h3 id="bienvenida">Bienvenido {{$nombre}}!!</h3>
<form action="index.php" method="post" id="cuadros">
    @foreach($cuadros as $cuadro)
    <h4>Cuadro: {{$cuadro->getTitulo()}}</h4>
    
    <a href="index.php?id={{$cuadro->getId()}}">
        <img src="img/{{$cuadro->getImagen()}}" alt="alt" height="200" width="300"/>
    </a>
    @endforeach
</form>
@endsection