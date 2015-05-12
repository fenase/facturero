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
    private static $handlers;
    private $lastHandler;
    private $lastName;

    function __construct($filename = NULL, $baseLevel = ERROR_LEVEL_ALL){
        if(is_null($filename)){
            $filename = directorySeparators(dirname(dirname(__FILE__)) . '/log/') . date('Ymd') . '.txt';
        }
        $this->baseLevel = $baseLevel;
        $dirname         = dirname($filename);
        if(!is_dir($dirname)){
            mkdir($dirname, 0755, true);
        }
        if(!self::$handlers[$filename]){
            self::$handlers[$filename] = fopen($filename, "a");
        }
        $this->lastHandler = self::$handlers[$filename];
        $this->lastName = $filename;
    }

    function __destruct(){
//        foreach(self::$handlers as $key => $value){
//            fclose($value);
//            unset(self::$handlers[$key]);
//        }
        fclose(self::$handlers[$this->lastName]);
        unset(self::$handlers[$this->lastName]);
    }

    function log($mensaje, $level = ERROR_LEVEL_INFO){
        if(0 != ($level & $this->baseLevel)){
            //obtengo fecha actual
            $fecha = date('[Y-m-d H:i:s]');
            //nivel
            $nivel = $this->getNivel($level);
            //escribo mensaje
            fwrite($this->lastHandler, $fecha . $nivel . $mensaje . "\r\n");
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
