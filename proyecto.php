<?php
/**
 * Visualización de un proyecto
 * @package frontEnd
 */

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'prepend.php');

if(!idValido($_GET['id'])){
    redirect('./proyectos.php');
}

$template = $twig->loadTemplate('proyecto.twig');

$proyecto = new Proyecto($_GET['id']);

if($_POST['accion'] == ACC_GUARDAR){
    $idsParticipantes = filtrarVacios(explode('|', $_POST['listSortOrder']));
    $proyecto->setParticipantes(Usuario::crearUsuarios($idsParticipantes, USER_SEARCH_TIPE_ID));
    $proyecto->guardar();
}


if(idValido($_GET['sacarParticipante'])){
    $proyecto->sacarParticipante($_GET['sacarParticipante']);
    $proyecto->guardar();
    redirect($_SERVER['PHP_SELF'] . '?id=' . $_GET['id']);
}
$twigVariables['proyecto'] = $proyecto;
$twigVariables['title']    = 'Vista de proyecto: ' . $proyecto->getNombre();

require_once('private/mainEcho.php');
