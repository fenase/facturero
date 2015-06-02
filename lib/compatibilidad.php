<?php

/*
 * Funciones para dar compatibilidad a versiones de php.
 * Acá se encuantran funciones que están presentes en versiones posteriores de php a la utilizada durante la mayor parte del desarrollo.
 */

if(!function_exists('spl_object_hash')){

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
