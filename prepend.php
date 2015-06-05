<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'compatibilidad.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'enviroment.php');

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constantes.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'auxiliares.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'funcionesDB.php');
//config devuelve la conexión a la base de datos
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php');


if(isset($esUnaPruebaEntoncesIgnorarSesiones)){
    return;
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
    $loader = new Twig_Loader_Filesystem(directorySeparators(BASEDIR . '/template'));
    $twig   = new Twig_Environment($loader,
                                   array(
        'cache' => (FACTURERO_DEBUG_MODE) ? FALSE : directorySeparators(dirname(__FILE__) . '/cache'),
    ));
    $twigVariables['config']    = array('BASEURL' => BASEURL);
    $twigVariables['userLogin'] = $_SESSION['userNombreReal'];
    //header de las páginas
    include_once dirname(__FILE__) . '/top.php';
    include_once dirname(__FILE__) . './bottom.php';
}else{
    //procesoAutomático
    chdir(dirname(__FILE__));
    require_once('phpmailer/PHPMailerAutoload.php');
}




