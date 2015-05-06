<?php

function directorySeparators($dir){
    $dir = str_replace('/', DIRECTORY_SEPARATOR, $dir);
    $dir = str_replace("\\", DIRECTORY_SEPARATOR, $dir);
    $dir2 = $dir;
    while($dir != ($dir2 = str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $dir))){
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
    $top_frame = array_pop($backtrace);
    return $top_frame['file'];
}

function getClaseVista(){
    $topmost = explode(DIRECTORY_SEPARATOR, str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, get_topmost_script()));//convierto separaciones de ruta para facilitar trabajo
    $topmost[count($topmost)-1] = explode('.', $topmost[count($topmost)-1]);//separo elementos de la ruta
    $topmost[count($topmost)-1][0] = 'vista_'.$topmost[count($topmost)-1][0];//modifico el nombre del archivo
    $topmost[count($topmost)] = implode('.', $topmost[count($topmost)-1]);//revierto moviendo
    $topmost[count($topmost)-2] = 'vista';//agrego carpeta de vistas. -2 porque el arreglo creció
    $filename = implode(DIRECTORY_SEPARATOR, $topmost);//revierto
    if(file_exists($filename)){
        return $filename;
    }else{
        return FALSE;
    }
}

function redirect($url){
    header('location: '.$url);
    exit();
}

function startsWith($string, $comienzo){
    return ($comienzo === '') || (strpos($string, $comienzo) === 0);
}

class NumericComparisonFilter {
        private $num;
        function __construct($num) {
                $this->num = $num;
        }
        function isLower($i) {
                return $i < $this->num;
        }
        function isGreater($i) {
                return $i > $this->num;
        }
        function isEqual($i) {
                return $i == $this->num;
        }
        function isLowerOrEqual($i) {
                return $i <= $this->num;
        }
        function isGreaterOrEqual($i) {
                return $i >= $this->num;
        }
}