<?php

function directorySeparators($dir){
    $dir  = str_replace('/', DIRECTORY_SEPARATOR, $dir);
    $dir  = str_replace("\\", DIRECTORY_SEPARATOR, $dir);
    $dir2 = $dir;
    while($dir != ($dir2 = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR,
                                       DIRECTORY_SEPARATOR, $dir))){
        $dir = $dir2;
    }
    return $dir;
}

function endsWith($string, $final){
    return ($final === '') ||
            (
            (($posMax = strlen($string) - strlen($final)) >= 0) &&
            (strpos($string, $final, $posMax) !== FALSE)
            );
}

function get_topmost_script(){
    if(defined('DEBUG_BACKTRACE_IGNORE_ARGS')){
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
    }else{
        $backtrace = debug_backtrace();
    }
    $topFrame = array_pop($backtrace);
    return $topFrame['file'];
}

function getClaseVista(){
    //convierto separaciones de ruta para facilitar trabajo
    $topmost                         = explode(DIRECTORY_SEPARATOR,
                                                    str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, get_topmost_script()));
    //separo elementos de la ruta
    $topmost[count($topmost) - 1]    = explode('.', $topmost[count($topmost) - 1]);
    //modifico el nombre del archivo
    $topmost[count($topmost) - 1][0] = 'vista_' . $topmost[count($topmost) - 1][0];
    //revierto moviendo
    $topmost[count($topmost)]        = implode('.', $topmost[count($topmost) - 1]);
    //agrego carpeta de vistas. -2 porque el arreglo creció
    $topmost[count($topmost) - 2]    = 'vista';
    //revierto
    $filename                        = implode(DIRECTORY_SEPARATOR, $topmost);
    if(file_exists($filename)){
        return $filename;
    }else{
        return FALSE;
    }
}

function redirect($url){
    header('location: ' . $url);
    exit();
}

function startsWith($string, $comienzo){
    return ($comienzo === '') || (strpos($string, $comienzo) === 0);
}

/**
 * Une los archivos en uno solo. excepcion en caso de falla.
 * @param string $archivoDestino Ubicación del archivo destino
 * @param array(string) $files Array de rutas a archivos
 * @return array(string) unión de $files con el archivo de salida (nuevo arreglo de archivos)
 * @throws Exception en caso de no poder abrir archivos
 */
function unirArchivos($archivoDestino, $files){
    $out = fopen($archivoDestino, 'w');
    $res = array();
    if(!$out){
        throw new Exception("Imposible abrir archivo $archivoDestino para escritura");
    }else{
        $res = array_merge($res, $files, array($archivoDestino));
    }
    foreach($files as $filename){
        $temp = file_get_contents($filename);
        if($temp === FALSE){
            fclose($out);
            @unlink($archivoDestino);
            throw new Exception("Imposible abrir archivo $filename para lectura");
        }
        fwrite($out, $temp);
    }
    fclose($out);
    return $res;
}

class NumericComparisonFilter{

    private $num;

    function __construct($num){
        $this->num = $num;
    }

    function isLower($i){
        return $i < $this->num;
    }

    function isGreater($i){
        return $i > $this->num;
    }

    function isEqual($i){
        return $i == $this->num;
    }
    
    function isNotEqual($i){
        return $i != $this->num;
    }

    function isLowerOrEqual($i){
        return $i <= $this->num;
    }

    function isGreaterOrEqual($i){
        return $i >= $this->num;
    }

}
