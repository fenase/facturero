<?php


/**
 * Description of vistaClass
 *
 * @author FedSeckel
 */
class vistaProyectos{
    private $contenido;
            
    function __construct($filename){
        $this->contenido = file_get_contents($filename);
    }
    
    function mostrar(){
        echo $this->contenido;
    }
    
    function proyectos($proyectos){
        $inicioCiclo    = '<!-- {{inicio.lista}} -->';
        $finCiclo       = '<!-- {{fin.lista}} -->';
        $inicioCicloLEN = strlen($inicioCiclo);
        $finCicloLEN    = strlen($finCiclo);
        foreach($proyectos as $proyecto){
            $inicioCicloPos = strpos($this->contenido, $inicioCiclo);
            $finCicloPos    = strpos($this->contenido, $finCiclo);
            $textAux        = substr($this->contenido, $inicioCicloPos + $inicioCicloLEN,
                                     $finCicloPos - $inicioCicloPos - $inicioCicloLEN);
            $textAux        = str_replace('<!-- {{id}} -->', $proyecto->getId(), $textAux);
            $textAux        = str_replace('<!-- {{nombre}} -->', $proyecto->getNombre(), $textAux);
            $textAux        = str_replace('<!-- {{frecuencia}} -->', $proyecto->getFrecuencia(), $textAux);
            $textAux        = str_replace('<!-- {{cantidad de participantes}} -->', $proyecto->getCantidadParticipantes(), $textAux);
            $textAux        = str_replace('<!-- {{accion}} -->', 'PONER ACCION', $textAux);
            $this->contenido           = substr_replace($this->contenido, $textAux, $inicioCicloPos, 0);
        }
        $inicioCicloPos = strpos($this->contenido, $inicioCiclo);
        $finCicloPos    = strpos($this->contenido, $finCiclo);
        $this->contenido           = substr($this->contenido, 0, $inicioCicloPos) . substr($this->contenido,
                                                                 $finCicloPos + $finCicloLEN);
    }
}
