<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$template              = $twig->loadTemplate('usuarios.tpl');
$variables['usuarios'] = Usuario::todosLosUsuarios();
$variables['config']   = array('BASEURL' => BASEURL);
echo $template->render($variables);
