<?php

/**
 * Funciones para dar compatibilidad a versiones de php.
 * Acá se encuantran funciones que están presentes en versiones posteriores de php a la utilizada durante la mayor parte del desarrollo.
 * @package backEnd
 */
if(!function_exists('spl_object_hash')){

    /**
     * Devuelve el id del hash del objeto dado
     * http://php.net/manual/es/function.spl-object-hash.php
     * @param $object
     * @return Un string que es único para cada objeto que existe actualmente y que siempre es el mismo para cada objeto
     */
    function spl_object_hash($object){
        if(is_object($object)){
            ob_start();
            var_dump($object);
            $dump = ob_get_contents();
            ob_end_clean();
            if(preg_match('/^object\(([a-z0-9_]+)\)\#(\d)+/i', $dump, $match)){
                return md5($match[1] . $match[2]);
            }
        }
        return null;
    }

}

if(!function_exists('json_encode')){

    /**
     * Función json_encode para php<5.2
     * Retorna la representación JSON del valor dado
     * @link http://stackoverflow.com/a/11684471 obtenido desde
     * @param $a
     * @return String
     */
    function json_encode($a = false){
        if(is_null($a)){
            return 'null';
        }
        if($a === false){
            return 'false';
        }
        if($a === true){
            return 'true';
        }
        if(is_scalar($a)){
            if(is_float($a)){
                // Always use "." for floats.
                return floatval(str_replace(",", ".", strval($a)));
            }

            if(is_string($a)){
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
            }else{
                return $a;
            }
        }
        $isList = true;
        for($i = 0, reset($a); $i < count($a); $i++, next($a)){
            if(key($a) !== $i){
                $isList = false;
                break;
            }
        }
        $result = array();
        if($isList){
            foreach($a as $v){
                $result[] = json_encode($v);
            }
            return '[' . join(',', $result) . ']';
        }else{
            foreach($a as $k => $v){
                $result[] = json_encode($k) . ':' . json_encode($v);
            }
            return '{' . join(',', $result) . '}';
        }
    }

}
