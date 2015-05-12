<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$vista = new VistaMain('./template/main.html');
$vista->preparar();
$vista->mostrar();

