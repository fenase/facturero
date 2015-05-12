<?php

/**
 * Clase de log
 *
 */
define('ERROR_LEVEL_CRITICAL', 1);
define('ERROR_LEVEL_ERROR', 2);
define('ERROR_LEVEL_WARNING', 4);
define('ERROR_LEVEL_INFO', 8);
define('ERROR_LEVEL_ALL', 15);

class Logger{

    private $baseLevel;
    private static $handler;
    private $filename;

    function __construct($baseLevel = ERROR_LEVEL_ALL){
        $this->filename  = directorySeparators(dirname(dirname(__FILE__)) . '/log/') . date('Ym') . '.txt';
        $this->baseLevel = $baseLevel;
        $this->abrir();
    }

    function __destruct(){
        fclose(self::$handler);
        self::$handler = NULL;
    }

    function log($mensaje, $level = ERROR_LEVEL_INFO){
        if(0 != ($level & $this->baseLevel)){
            //obtengo fecha actual
            $fecha = date('[Y-m-d H:i:s]');
            //nivel
            $nivel = $this->getNivel($level);
            //abro archivo (sólo si es necesario: se controla desde adentro)
            $this->abrir();
            //escribo mensaje
            fwrite(self::$handler, $fecha . $nivel . $mensaje . "\r\n");
        }
    }

    private function abrir(){
        $dirname = dirname($this->filename);
        if(!is_dir($dirname)){
            mkdir($dirname, 0755, true);
        }
        if(!self::$handler){
            self::$handler = fopen($this->filename, "a");
        }
    }

    private function getNivel($level){
        //los espacios son importantes
        switch($level){
            case ERROR_LEVEL_CRITICAL:
                $nivel = "[CRITICAL] ";
                break;
            case ERROR_LEVEL_ERROR:
                $nivel = "[ERROR]    ";
                break;
            case ERROR_LEVEL_WARNING:
                $nivel = "[WARNING]  ";
                break;
            case ERROR_LEVEL_INFO:
                $nivel = "[INFO]     ";
                break;
            default:
                $nivel = "           ";
                break;
        }
        return $nivel;
    }

}
