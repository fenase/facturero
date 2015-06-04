<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$template                  = $twig->loadTemplate('usuarios.twig');
$twigVariables['usuarios'] = Usuario::todosLosUsuarios();

require_once 'mainEcho.php';
