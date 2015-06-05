<?php

set_exception_handler('controlExcepciones');

spl_autoload_register('autoloadTipos');
spl_autoload_register('autoloadClases');
spl_autoload_register('autoloadLibrerias');

function controlExcepciones($e){
    $logger = new Logger();
    $logger->log($e->getMessage(), ERROR_LEVEL_CRITICAL);
    die($e->getMessage());
}

//autoload
//tipos de datos
function autoloadTipos($classname){
    $filename = directorySeparators(BASEDIR . "/tipos/" . $classname . ".php");
    if(file_exists($filename)){
        require_once($filename);
    }
}

//clases
function autoloadClases($classname){
    $filename = directorySeparators(BASEDIR . "/lib/" . $classname . ".lib.php");
    if(file_exists($filename)){
        require_once($filename);
    }
}

//TWIG
function autoloadLibrerias($classname){
    if(is_file($file = BASEDIR . '/lib/' . str_replace(array('_',
                        "\0"), array('/', ''), $classname) . '.php')){
        //TWIG
        require_once $file;
    }
}
