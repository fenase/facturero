<?php

/**
 * Description of vistaClass
 *
 * @author FedSeckel
 */
class vistaMain{

    private $contenido;

    function __construct($filename){
        $this->contenido = file_get_contents($filename);
    }

    function mostrar(){
        echo $this->contenido;
    }

    function preparar(){
        
    }

}
