<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$vista = new vistaMain('./template/main.html');
$vista->preparar();
$vista->mostrar();

