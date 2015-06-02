<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$template = $twig->loadTemplate('main.tpl');
$variables = array();
echo $template->render($variables);

