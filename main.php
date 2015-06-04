<?php

$twigVariables['title'] = 'Página principal';

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$template = $twig->loadTemplate('main.twig');

include('mainEcho.php');

