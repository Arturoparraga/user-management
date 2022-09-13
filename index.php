<?php

require "vendor/autoload.php";
require "clases/DataBase.php";
require "clases/Usuario.php";
require "clases/Pintor.php";
require "clases/Cuadro.php";

use eftec\bladeone\BladeOne;
use DataBase\DataBase;

$views = __DIR__ . '\views';
$cache = __DIR__ . '\cache';

$blade = new BladeOne($views, $cache);
$blade->setBaseURL("http://localhost:8000");

session_start();

if (empty($_REQUEST) || isset($_POST['cerrarSesion'])) {
    $pintores = Pintor::recuperaPintores(DataBase::getConexion());
    $_SESSION['pintores'] = $pintores;

    echo $blade->run('register', ['pintores' => $pintores]);
} elseif (isset($_POST['registrarse'])) {

    $nombre = filter_input(INPUT_POST, 'usuario');
    $email = filter_input(INPUT_POST, 'email');
    $contraseña = filter_input(INPUT_POST, 'contraseña');
    $pintor = filter_input(INPUT_POST, 'pintores');
    $id = null;

    $usuario = new Usuario($id, $nombre, $contraseña, $email, $pintor);

    if ($usuario->persiste(DataBase::getConexion())) {
        $texto = "Registrado correctamente !";
        echo $blade->run('login', ['texto' => $texto]);
    } else {
        $textoError = "ERROR";
        echo $blade->run('register');
    }
} elseif (isset($_POST['irLogin'])) {

    $texto = "";
    echo $blade->run('login', ['texto' => $texto]);
} elseif (isset($_POST['login'])) {

    $nombreUsuario = filter_input(INPUT_POST, 'usuario');
    $contra = filter_input(INPUT_POST, 'contraseña');
    $_SESSION['nombre'] = $nombreUsuario;
    $_SESSION['contra'] = $contra;

    $usuario = Usuario::recuperaUsuarioPorCredenciales((DataBase::getConexion()), $nombreUsuario, $contra);

    if (!is_null($usuario)) {

        $pintorObjeto = $usuario->getPintor();
        $nombrePintor = $pintorObjeto->getNombre();
        $cuadros = $pintorObjeto->getPaintings();

        $_SESSION['usuarios'] = $usuario;
        $_SESSION['nombrePintor'] = $nombrePintor;
        $_SESSION['cuadros'] = $cuadros;

        echo $blade->run('contenido', ['nombre' => $usuario->getNombre(), 'cuadros' => $cuadros]);
    } else {
        $texto = "Credenciales incorrectas !";
        echo $blade->run('login', ['texto' => $texto]);
    }
} elseif (isset($_POST['volver'])) {
    $usuario = $_SESSION['usuarios'];
    $cuadros = $_SESSION['cuadros'];

    echo $blade->run('contenido', ['nombre' => $usuario->getNombre(), 'cuadros' => $cuadros]);
} elseif (isset($_POST['borrar'])) {

    $usuario = $_SESSION['usuarios'];
    $pintores = $_SESSION['pintores'];
    $usuario->borra(DataBase::getConexion(), $_SESSION['nombre']);

    $_SESSION['usuarios'] = $usuario;
    $_SESSION['pintores'] = $pintores;

    echo $blade->run('register', ['pintores' => $pintores]);
} elseif (isset($_POST['irCambiarDatos'])) {

    $usuario = $_SESSION['usuarios'];
    $pintores = $_SESSION['pintores'];
    $nombrePintor = $_SESSION['nombrePintor'];
    echo $blade->run('cambiarDatos', ['nombre' => $usuario->getNombre(), 'contra' => $usuario->getContraseña(), 'email' => $usuario->getEmail(), 'pintores' => $pintores, 'pintorViejo' => $nombrePintor]);
} elseif (isset($_POST['guardar'])) {

    $nuevoNombre = filter_input(INPUT_POST, 'nuevoNombre');
    $nuevoEmail = filter_input(INPUT_POST, 'nuevoEmail');
    $nuevaContraseña = filter_input(INPUT_POST, 'nuevaContraseña');
    $nuevoPintor = filter_input(INPUT_POST, 'nuevosPintores');
    $nuevoId = null;

    $usuario = $_SESSION['usuarios'];

    $usuario->setNombre($nuevoNombre);
    $usuario->setContraseña($nuevaContraseña);
    $usuario->setEmail($nuevoEmail);
    $usuario->setPintor($nuevoPintor);

    $usuario->persiste(DataBase::getConexion());
    $usuario = Usuario::recuperaUsuarioPorCredenciales((DataBase::getConexion()), $nuevoNombre, $nuevaContraseña);
    $pintorObjeto = $usuario->getPintor();
    $nombrePintor = $pintorObjeto->getNombre();
    $cuadros = $pintorObjeto->getPaintings();

    $_SESSION['usuarios'] = $usuario;
    $_SESSION['nombrePintor'] = $nombrePintor;
    $_SESSION['cuadros'] = $cuadros;

    $texto = "Datos cambiados correctamente!";

    echo $blade->run('contenido', ['nombre' => $usuario->getNombre(), 'cuadros' => $cuadros]);
}
if (isset($_REQUEST['id'])) {
    $idCuadro = $_REQUEST['id'];
    $cuadros = $_SESSION['cuadros'];
    $nombrePintor = $_SESSION['nombrePintor'];
    foreach ($cuadros as $cuadro) {
        if ($cuadro->getId() == $idCuadro) {
            $titulo = $cuadro->getTitulo();
            $img = $cuadro->getImagen();
            $año = $cuadro->getAño();
            $descripcion = $cuadro->getDescripcion();
            $epoca = $cuadro->getEpoca();
        }
    }

    echo $blade->run('contenidoDetallado', ['titulo' => $titulo, 'img' => $img, 'año' => $año, 'descripcion' => $descripcion, 'epoca' => $epoca, 'pintor' => $nombrePintor]);
}