@extends('app')
@section('content')
<h2>Iniciar sesion</h2>
<form method="POST" action="index.php" id="login">
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required /><br><br>
    <label for="contraseña">Contraseña:</label>
    <input type="password" id="contraseña" name="contraseña" required /><br><br>
    <button type="submit" id="botonlogin" name="login">Iniciar Sesion</button>
    <p>{{$texto}}</p>
</form>
@endsection