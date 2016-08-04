<?php
/**
 * Menú de proyectos
 * @package frontEnd
 */

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'prepend.php');

$template                   = $twig->loadTemplate('proyectos.twig');
$twigVariables['proyectos'] = Proyecto::todosLosProyectos();

require_once('private/mainEcho.php');
