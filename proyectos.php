<?php

$link = require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'prepend.php');

$vista = new vistaProyectos('./template/proyectos.html');
$vista->proyectos(proyecto::todosLosProyectos());
$vista->mostrar();

