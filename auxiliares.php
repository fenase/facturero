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

/**
 * Devuelve la ruta al archivo principal que se entá ejecutando.
 * @param boolean $filenameOnly sólo devolver el nombre de archivo y no la ruta completa
 * @return string archivo en ejecución
 */
function get_topmost_script($filenameOnly = FALSE){
    if(defined('DEBUG_BACKTRACE_IGNORE_ARGS')){
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
    }else{
        $backtrace = debug_backtrace();
    }
    $topFrame = array_pop($backtrace);
    if(!$filenameOnly){
        return $topFrame['file'];
    }else{
        return basename($topFrame['file']);
    }
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

/**
 * array_search buscando por un campo determinado.
 * @param type $needle ¿Qué se busca?
 * @param type $haystack ¿En qué diccionario?
 * @param type $field ¿Qué campo hay que comparar?
 * @return int clave del valor encontrado, FALSE en caso de no encontrarse
 */
function getIndexByField($needle, $haystack, $field){
    foreach($haystack as $index => $innerArray){
        if(isset($innerArray[$field]) && $innerArray[$field] === $needle){
            return $index;
        }
    }
    return false;
}

function idValido($id){
    $res = TRUE;
    $res = $res && isset($id);
    $res = $res && is_numeric($id);
    $res = $res && (floor($id) == $id);
    return ( $res && ($res > 0) );
}

/**
 * Encuentra la raíz de una página para saber cuál marcar en el menú
 * @param string $pagina página para buscar su origen
 * @return nombre de página padre si se encuentra, FALSE si no
 */
function obtenerRaiz($pagina){
    foreach(unserialize(SECCIONES_HIJOS) as $padre => $hijos){
        if(in_array($pagina, $hijos)){
            return $padre;
        }
    }
    return FALSE;
}

/**
 * Devuelve un array con los elementos del menú superior correspondientes a la página que está viendo el usuario.
 * @param string $pagina página actual (default: get_topmost_script(TRUE))
 * @return array Elementos para el menú
 */
function obtenerSecciones($pagina = NULL){
    //obtengo la página abierta (en caso de no proveerse)
    $pagina = ($pagina === NULL) ? get_topmost_script(TRUE) : $pagina;
    //obtengo la raíz
    $raiz = obtenerRaiz($pagina);
    $pagina = $raiz ? $raiz : $pagina;
    $secciones = array();
    foreach(unserialize(SECCIONES_POSIBLES) as $seccion){
        if($pagina == $seccion['pagina']){
            $seccion['active'] = TRUE;
        }
        $secciones[] = $seccion;
    }
    //segunda pasada para deshabilitar secciones
    foreach(unserialize(SECCIONES_POSIBLES) as $seccion){
        if($pagina == $seccion['pagina']){
            foreach($seccion['deshabilita'] as $deshabilitar){
                $secciones[getIndexByField($deshabilitar, $secciones, 'pagina')]['disabled'] = TRUE;
            }
        }
    }
    return $secciones;
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
