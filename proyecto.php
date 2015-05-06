<?php

$link = require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'prepend.php');

if(!idValido($_GET['id'])){
    redirect('./proyectos.php');
}

$vista = new vistaProyecto('./template/proyecto.html');
$proyecto = new proyecto($_GET['id']);


if(idValido($_GET['sacarParticipante'])){
    $proyecto->sacarParticipante($_GET['sacarParticipante']);
    $proyecto->guardar();
    redirect($_SERVER['PHP_SELF'].'?id='.$_GET['id']);
}



$vista->proyecto($proyecto);
$vista->mostrar();





function idValido($id){
    $res = TRUE;
    $res = $res && isset($id);
    $res = $res && is_numeric($id);
    $res = $res && (floor($id) == $id);
    $res = $res && ($res > 0);
    return $res;
}