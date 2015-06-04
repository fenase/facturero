<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$template                   = $twig->loadTemplate('proyectos.twig');
$twigVariables['proyectos'] = Proyecto::todosLosProyectos();

require_once 'mainEcho.php';
