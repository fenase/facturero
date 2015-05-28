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
    private $noPuedoAbrirArchivo;

    function __construct($baseLevel = ERROR_LEVEL_ALL){
        $this->filename  = directorySeparators(dirname(dirname(__FILE__)) . '/log/') . date('Ymd') . '.txt';
        $this->baseLevel = $baseLevel;
        $this->abrir();
        $this->rotar();
    }

    function __destruct(){
        if(self::$handler){
            fclose(self::$handler);
            self::$handler = NULL;
        }
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
            if(!$this->noPuedoAbrirArchivo){
                fwrite(self::$handler, $fecha . $nivel . $mensaje . "\r\n");
            }else{
                /* se debería cambiar la forma en la que reacciona en caso de no poder guardar logs.
                 * mandar todo por pantalla no es la mejor opción
                 */
                print("ERROR DE LOGGER. Mensaje: <<" . $fecha . $nivel . $mensaje . ">>\r\n");
            }
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
        //control de fallas
        if(!self::$handler){
            $this->noPuedoAbrirArchivo = TRUE;
        }else{
            $this->noPuedoAbrirArchivo = FALSE;
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

    /**
     * Comprime los registros del mes pasado
     */
    private function rotar(){
        //obtengo patrones
        $dir    = directorySeparators(dirname(dirname(__FILE__)) . '/log/');
        $mes    = date('Ym', strtotime("-1 month"));
        //ver cómo rotar en caso que haya archivos de más de un mes.
        $patron = $mes . '*.txt';
        $files  = glob($dir . $patron);
        //si no hay archivos para comprimir, salgo y continuo por otro lado
        if(!$files || count($files) == 0){
            return;
        }
        //comprimo archivos del mes pasado
        if($this->rotarComprimir($files, $dir . $mes . '.zip')){
            //elimino los archivos comprimidos
            $this->rotarEliminarArchivos($files);
        }
    }

    private function rotarComprimir($files, $archivoDestino){
        try{
            $archive = new PclZip($archivoDestino);
            $addRet  = $archive->add($files, PCLZIP_OPT_REMOVE_ALL_PATH);
            if(!$addRet){
                throw new Exception("Error: " . $archive->errorInfo(true));
            }
            $exito = TRUE;
        }catch(Exception $e){
            $this->log('Imposible almcenar archivos de registro antíguos. ' . $e->getMessage(),
                       ERROR_LEVEL_WARNING);
            $exito = FALSE;
        }
        return $exito;
    }

    private function rotarEliminarArchivos($files){
        foreach($files as $file){
            if(!@unlink($file)){
                $this->log("No se puede eliminar el archivo de log almacenado $file",
                           ERROR_LEVEL_WARNING);
            }
        }
    }

}
