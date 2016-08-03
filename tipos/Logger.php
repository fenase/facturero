<?php

/**
 * @package Logger
 */
/** int 1 */
define('ERROR_LEVEL_CRITICAL', 1);
/** int 2 */
define('ERROR_LEVEL_ERROR', 2);
/** int 4 */
define('ERROR_LEVEL_WARNING', 4);
/** int 8 */
define('ERROR_LEVEL_INFO', 8);
/** int 15 (1|2|4|8) Activa todos los errores */
define('ERROR_LEVEL_ALL', 15);

/**
 * Clase de log
 */
class Logger{

    /** @var int Descriptionint nivel de log deseado en forma de máscara. */
    private $baseLevel;

    /** @var resource puntero al archivo de log */
    private static $handler;

    /** @var string nombre del archivo de log */
    private $filename;

    /** @var boolean TRUE si no se pudo abrir el archivo */
    private $noPuedoAbrirArchivo;

    /**
     * Constructor de la clase.
     * Crea el archivo de log del día si no existe.
     * Además, une y comprime los archivos de log del mes anterior.
     * @param int $baseLevel qué niveles debe loguear, con forma de máscara: críticos: 1; errores: 2; advertencias: 4
     * información: 8. Si sólo se desean los errores críticos y las advertencias, por ejemplo, se deberá introducir un 3.
     * Se definieron constantes para mayor comodidad: ERROR_LEVEL_CRITICAL, ERROR_LEVEL_ERROR, ERROR_LEVEL_WARNING, ERROR_LEVEL_INFO, ERROR_LEVEL_ALL
     * 
     */
    function __construct($baseLevel = ERROR_LEVEL_ALL){
        $this->filename  = directorySeparators(dirname(dirname(__FILE__)) . '/log/') . date('Ymd') . '.txt';
        $this->baseLevel = $baseLevel;
        $this->abrir();
        $this->rotar();
    }

    /**
     * destructor de clase: cierra el archivo.
     */
    function __destruct(){
        if(self::$handler){
            fclose(self::$handler);
            self::$handler = NULL;
        }
    }

    /**
     * Guarda en el archivo de log del día el mensaje declarado en $mensaje con el nivel $level, 
     * siempre y cuando el nivel esté permitido al momento de crear el objeto de log.
     * @param string $mensaje
     * @param int $level
     */
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

    /**
     * Abre el archivo de log para su escritura.
     * Si no existe, lo crea.
     * Si no existe el directorio, lo crea recursivamente.
     */
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

    /**
     * Obtiene el texto formateado correspondiente al nivel de error ingresado para marcar los mensajes en el archivo de acuerdo a su nivel.
     * @param in $level nivel de error
     * @return string texto
     */
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
     * Une y comprime los registros de los meses anteriores
     */
    private function rotar(){
        $dir           = directorySeparators(dirname(dirname(__FILE__)) . '/log/');
        //uso ciclo para rotar todos los meses
        //mientras haya archivos de texto (nota: se espera que sólo haya archivos con patrón "añomesdia.txt")
        $diferenciaMes = 0;
        while(glob($dir . '*.txt')){
            //inicializo en 0 y decremento ACÁ para poder usar "continue" más adelante.
            --$diferenciaMes;
            if($diferenciaMes < -96){
                //busco archivos de 8 años. Si siguen habiendo archivos de texto, hay basura en la carpeta de log.
                break;
            }
            //obtengo patrones
            $mes    = date('Ym', strtotime($diferenciaMes . " month"));
            $patron = $mes . '*.txt';
            $files  = glob($dir . $patron);
            //si no hay archivos para comprimir, continuo con otro mes
            if(!$files || count($files) == 0){
                continue;
            }
            //comprimo archivos del mes pasado
            if($this->rotarComprimir($files, $dir . $mes . '.txt')){
                //elimino los archivos comprimidos
                $this->rotarEliminarArchivos($files);
            }
        }
    }

    /**
     * Parte de rotar. Une y comprime los archivos pasados por parámetro
     * Agrega a la lista de archivos el archivo descomprimido resultante de la unión.
     * @param (ref)array(string) $files
     * @param string $archivoDestino
     * @return boolean
     * @throws Exception
     */
    private function rotarComprimir(&$files, $archivoDestino){
        try{
            $files   = unirArchivos($archivoDestino, $files);
            $archive = new PclZip($archivoDestino . '.zip');
            $addRet  = $archive->add($archivoDestino, PCLZIP_OPT_REMOVE_ALL_PATH);
            if(!$addRet){
                throw new Exception("Error: " . $archive->errorInfo(true));
            }
            $exito = TRUE;
        }catch(Exception $e){
            $this->log('Imposible almcenar archivos de registro antíguos. ' . $e->getMessage(), ERROR_LEVEL_WARNING);
            $exito = FALSE;
        }
        return $exito;
    }

    /**
     * Elimina todos los archivos de la lista
     * @param array(string) $files
     */
    private function rotarEliminarArchivos($files){
        foreach($files as $file){
            if(!@unlink($file)){
                $this->log("No se puede eliminar el archivo de log almacenado $file", ERROR_LEVEL_WARNING);
            }
        }
    }

}
