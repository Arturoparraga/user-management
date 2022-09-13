@extends('app')
@section('content')
<h2>Registro de datos</h2>
<form method="POST" action="index.php" id="register">
    <label>Usuario:</label>
    <input type="text" id="usuario" name="usuario" required /><br><br>
    <label>Email:</label>
    <input type="email" name="email" required><br><br>
    <label>Contraseña:</label>
    <input type="password" id="contraseña" name="contraseña" required /><br><br>
    <label>Pintores:</label>
    <select id="pintores" name="pintores">
        @foreach ($pintores as $pintor)
        <option value="{{$pintor->getId()}}">{{$pintor->getNombre()}}</option>
        @endforeach
    </select>
    <br>
    <br>
    <button type="submit" id="botonregister" name="registrarse">Registrarse</button>
</form>
<form action="index.php" method="post" id="register">
    <button type="submit" name="irLogin">Iniciar Sesion</button>
</form>
@endsection
