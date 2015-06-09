<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'prepend.php');


if(!idValido($_GET['id'])){
    redirect('./usuarios.php');
}

$template = $twig->loadTemplate('usuario.twig');

$usuario = new Usuario($_GET['id']);


$twigVariables['usuario']          = $usuario;
$twigVariables['proyectosUsuario'] = $usuario->proyectos();
$twigVariables['title']            = $usuario->getNombre();

require_once('private/mainEcho.php');
