<?php
/**
 * configuración de ambiente y autoloader de clases
 * @package backEnd
 */

set_exception_handler('controlExcepciones');

spl_autoload_register('autoloadTipos');
spl_autoload_register('autoloadClases');
spl_autoload_register('autoloadLibrerias');

/**
 * Captura las excepciones no capturadas, registra el error y detiene el programa
 * @param Exception $e
 */
function controlExcepciones($e){
    $logger = new Logger();
    $logger->log($e->getMessage(), ERROR_LEVEL_CRITICAL);
    die($e->getMessage());
}

/**
 * carga (require_once) el archivo que contiene el tipo de datos requerido de acuerdo a su nombre
 * @param string $classname tipo de dato (nombre clase objeto)
 */
function autoloadTipos($classname){
    $filename = directorySeparators(BASEDIR . "/tipos/" . $classname . ".php");
    if(file_exists($filename)){
        require_once($filename);
    }
}

/**
 * carga (require_once) el archivo que contiene la librería requerida de acuerdo a su nombre
 * @param string $classname nombre librería
 */
function autoloadClases($classname){
    $filename = directorySeparators(BASEDIR . "/lib/" . $classname . ".lib.php");
    if(file_exists($filename)){
        require_once($filename);
    }
}

/**
 * carga (require_once) el archivo que contiene la librería requerida de acuerdo a su nombre para el sistema de templates TWIG
 * @param string $classname nombre librería TWIG
 */
function autoloadLibrerias($classname){
    if(is_file($file = BASEDIR . '/lib/' . str_replace(array('_',
                        "\0"), array('/', ''), $classname) . '.php')){
        //TWIG
        require_once $file;
    }
}
