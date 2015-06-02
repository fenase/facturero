<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$variables['config'] = array('BASEURL' => BASEURL);

if(!idValido($_GET['id'])){
    redirect('./proyectos.php');
}

$template = $twig->loadTemplate('proyecto.tpl');

$proyecto = new Proyecto($_GET['id']);


if(idValido($_GET['sacarParticipante'])){
    $proyecto->sacarParticipante($_GET['sacarParticipante']);
    $proyecto->guardar();
    redirect($_SERVER['PHP_SELF'] . '?id=' . $_GET['id']);
}
$variables['proyecto'] = $proyecto;
echo $template->render($variables);
