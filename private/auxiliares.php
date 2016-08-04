<?php

/**
 * Funciones Auxiliares del sistema
 * @package Funciones Auxiliares
 * @author fedseckel
 */

/**
 * Modifica una ruta, intercambiando las barras ('\' y '/' por la correspondiente al sistem operativo en ejecución
 * @param string $dir ruta a modificar
 * @return string ruta modificada
 */
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

/**
 * Verifica que el $string finalice con $final
 * @param string $string
 * @param string $final
 * @return type
 */
function endsWith($string, $final){
    return ($final === '') ||
            (
            (($posMax = strlen($string) - strlen($final)) >= 0) &&
            (strpos($string, $final, $posMax) !== FALSE)
            );
}

/**
 * Elimina de un array los strings vacios
 * @param array(string) $a
 * @return array(string)
 */
function filtrarVacios($a){
    return array_filter($a, 'not_empty_string');
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

/**
 * array_search buscando por un campo determinado.
 * @param $needle ¿Qué se busca?
 * @param array $haystack ¿En qué diccionario?
 * @param string $field ¿Qué campo hay que comparar?
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

/**
 * Verifica la probabilidad de que un valor sea una identificación
 * @param mixed $id
 * @return boolean
 */
function idValido($id){
    $res = TRUE;
    $res = $res && isset($id);
    $res = $res && is_numeric($id);
    $res = $res && (floor($id) == $id);
    return ( $res && ($res > 0) );
}

/**
 * Devuelve true si $s no es el string vacio. False si es vacio.
 * True en otros tipos de datos.
 * @param string $s
 * @return boolean no es string vacio
 */
function not_empty_string($s){
    return $s !== "";
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
    $pagina    = ($pagina === NULL) ? get_topmost_script(TRUE) : $pagina;
    //obtengo la raíz
    $raiz      = obtenerRaiz($pagina);
    $pagina    = $raiz ? $raiz : $pagina;
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

/**
 * redirige el navegador al destino
 * @param string $url destino
 */
function redirect($url){
    header('location: ' . $url);
    exit();
}

/**
 * Verifica que el $string comience con $comienzo
 * @param string $string
 * @param string $comienzo
 * @return boolean
 */
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

/**
 * Clase de comparaciones numéricas.
 * Construir la clase con el primer valor a comparar.
 * Llamar las funciones pasando el segundo como parámetro.
 * @author fedseckel
 */
class NumericComparisonFilter{

    /** @var numeric $num primer elemento de la comparación (base) */
    private $num;

    /**
     * Crea el comparador con el primer elemento a comaparar (base)
     * @param numeric $num
     */
    function __construct($num){
        $this->num = $num;
    }

    /**
     * Devuelve TRUE si $i es menor a la base de comparación
     * @param numeric $i
     * @return boolean
     */
    function isLower($i){
        return $i < $this->num;
    }

    /**
     * Devuelve TRUE si $i es mayor a la base de comparación
     * @param numeric $i
     * @return boolean
     */
    function isGreater($i){
        return $i > $this->num;
    }

    /**
     * Devuelve TRUE si $i es igual a la base de comparación
     * @param numeric $i
     * @return boolean
     */
    function isEqual($i){
        return $i == $this->num;
    }

    /**
     * Devuelve TRUE si $i es distinto a la base de comparación
     * @param numeric $i
     * @return boolean
     */
    function isNotEqual($i){
        return $i != $this->num;
    }

    /**
     * Devuelve TRUE si $i es menor o igual a la base de comparación
     * @param numeric $i
     * @return boolean
     */
    function isLowerOrEqual($i){
        return $i <= $this->num;
    }

    /**
     * Devuelve TRUE si $i es mayor o igual a la base de comparación
     * @param numeric $i
     * @return boolean
     */
    function isGreaterOrEqual($i){
        return $i >= $this->num;
    }

}
