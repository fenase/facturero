<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$variables['config'] = array('BASEURL' => BASEURL);

if(!idValido($_GET['id'])){
    redirect('./usuarios.php');
}

$template = $twig->loadTemplate('usuario.tpl');

$usuario = new Usuario($_GET['id']);


$variables['usuario'] = $usuario;
$variables['proyectosUsuario'] = $usuario->proyectos();
echo $template->render($variables);
