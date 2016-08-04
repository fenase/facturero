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
