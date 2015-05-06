<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constantes.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'auxiliares.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'funcionesDB.php');
$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php'); //config devuelve la conexión a la base de datos
//tipos de datos
require_once(dirname(__file__) . DIRECTORY_SEPARATOR . 'tipos' . DIRECTORY_SEPARATOR . 'proyecto.php');
require_once(dirname(__file__) . DIRECTORY_SEPARATOR . 'tipos' . DIRECTORY_SEPARATOR . 'usuario.php');

if(php_sapi_name() != 'cli'){
    //web
    session_name('factureroBF');
    session_start();
    if(!$_SESSION['user'] && !endsWith(directorySeparators(get_topmost_script()),
                                                           directorySeparators('facturero\index.php'))){
        header('location: ' . INDEXURL);
    }
    if(($claseVista = getClaseVista())){
        require_once($claseVista);
    }
}else{
    //procesoAutomático
    chdir(dirname(__FILE__));
    require_once('phpmailer/PHPMailerAutoload.php');
}




return $link;


