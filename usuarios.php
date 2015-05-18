<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$vista = new VistaUsuarios('./template/usuarios.html');
$vista->usuarios(Usuario::todosLosUsuarios());
$vista->mostrar();

