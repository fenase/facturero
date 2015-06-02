<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$template               = $twig->loadTemplate('proyectos.tpl');
$variables['proyectos'] = Proyecto::todosLosProyectos();
$variables['config']    = array('BASEURL' => BASEURL);
echo $template->render($variables);
