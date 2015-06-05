<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'prepend.php');

if(!idValido($_GET['id'])){
    redirect('./proyectos.php');
}

$template = $twig->loadTemplate('proyecto.twig');

$proyecto = new Proyecto($_GET['id']);


if(idValido($_GET['sacarParticipante'])){
    $proyecto->sacarParticipante($_GET['sacarParticipante']);
    $proyecto->guardar();
    redirect($_SERVER['PHP_SELF'] . '?id=' . $_GET['id']);
}
$twigVariables['proyecto'] = $proyecto;
$twigVariables['title']    = 'Vista de proyecto: ' . $proyecto;

require_once('private/mainEcho.php');
