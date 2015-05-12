<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$vista = new VistaProyectos('./template/proyectos.html');
$vista->proyectos(Proyecto::todosLosProyectos());
$vista->mostrar();

