@extends('app')
@section('content')
<h2>Cambiar los datos</h2>
<form method="POST" action="index.php" id="cambiarDatos">
    <label>Usuario nuevo:</label>
    <input type="text" id="usuario" name="nuevoNombre" required value="{{$nombre}}"/><br><br>
    <label>Email nuevo:</label>
    <input type="email" name="nuevoEmail" required value="{{$email}}"><br><br>
    <label>Contraseña nueva:</label>
    <input type="password" id="contraseña" name="nuevaContraseña" required value="{{$contra}}"/><br><br>
    <label>Pintores:</label>
    <select id="pintores" name="nuevosPintores">
        @foreach ($pintores as $pintor)
        @if($pintorViejo == $pintor)
        <option value="{{$pintor->getId()}}" selected>{{$pintor->getNombre()}}</option>
        @else
        <option value="{{$pintor->getId()}}" >{{$pintor->getNombre()}}</option>
        @endif
        @endforeach
    </select>
    <input type="submit" value="Guardar datos" name="guardar"/>
</form>
<form action="index.php" method="post" id="cambiarDatos">
    <input type="submit" value="Volver atras" name="volver"/>
</form>
@endsection