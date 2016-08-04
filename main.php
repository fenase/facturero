<?php
/**
 * Página principal del sitio (con usuario logueado)
 * @package frontEnd
 */

$twigVariables['title'] = 'Página principal';

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'prepend.php');

$template = $twig->loadTemplate('main.twig');

require_once('private/mainEcho.php');

