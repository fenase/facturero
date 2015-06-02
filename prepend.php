<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'compatibilidad.php');

function controlExcepciones($e){
    $logger = new Logger();
    $logger->log($e->getMessage(), ERROR_LEVEL_CRITICAL);
    die($e->getMessage());
}

set_exception_handler('controlExcepciones');

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constantes.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'auxiliares.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'funcionesDB.php');
//config devuelve la conexión a la base de datos
$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php');

//tipos de datos
function __autoload($classname){
    $filename = array(
        'clases'    => directorySeparators(dirname(__FILE__) . "/tipos/" . $classname . ".php"),
        'librerias' => directorySeparators(dirname(__FILE__) . "/lib/" . $classname . ".lib.php"));
    if(file_exists($filename['clases'])){
        //clases
        require_once($filename['clases']);
    }elseif(file_exists($filename['librerias'])){
        //clases
        require_once($filename['librerias']);
    }elseif(is_file($file = dirname(__FILE__) . '/lib/' . str_replace(array('_',
                        "\0"), array('/', ''), $classname) . '.php')){
        require $file;
    }else{
        throw new Exception("Clase $classname no encontrada");
    }
}

if(isset($esUnaPruebaEntoncesIgnorarSesiones)){
    return $link;
}

if(php_sapi_name() != 'cli' && !isset($esUnaPruebaDelProceso)){
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
    //Twig
    $loader = new Twig_Loader_Filesystem(directorySeparators(dirname(__FILE__) . '/template'));
    global $twig;
    $twig   = new Twig_Environment($loader,
                                   array(
        'cache' => (FACTURERO_DEBUG_MODE) ? FALSE : directorySeparators(dirname(__FILE__) . '/cache'),
    ));
}else{
    //procesoAutomático
    chdir(dirname(__FILE__));
    require_once('phpmailer/PHPMailerAutoload.php');
}




return $link;


