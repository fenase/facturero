<?php

/**
 * Menú de proyectos
 * @package frontEnd
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'prepend.php');

if($_POST['accion'] == ACC_GUARDAR){
    $nuevoProyecto = new Proyecto(0, $_POST);
    $nuevoProyecto->guardar();
}


$template                   = $twig->loadTemplate('proyectos.twig');
$twigVariables['proyectos'] = Proyecto::todosLosProyectos();

$twigVariables['camposNuevoP'] = Proyecto::obtenerCamposVisibles(PROY_FIELD_CREATE);

require_once('private/mainEcho.php');
