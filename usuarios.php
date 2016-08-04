<?php
/**
 * Menú de usuarios
 * @package frontEnd
 */

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'prepend.php');

$template                  = $twig->loadTemplate('usuarios.twig');
$twigVariables['usuarios'] = Usuario::todosLosUsuarios();

require_once('private/mainEcho.php');
