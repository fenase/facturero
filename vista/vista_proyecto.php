<?php

/**
 * Description of vistaClass
 *
 * @author FedSeckel
 */
class VistaProyecto{

    private $contenido;

    function __construct($filename){
        $this->contenido = file_get_contents($filename);
    }

    function mostrar(){
        echo $this->contenido;
    }

    function proyecto($proyecto){

        $this->contenido = str_replace('<!-- {{id}} -->', $proyecto->getId(),
                                       $this->contenido);
        $this->contenido = str_replace('<!-- {{nombre}} -->',
                                       $proyecto->getNombre(), $this->contenido);
        $this->contenido = str_replace('<!-- {{frecuencia}} -->',
                                       $proyecto->getFrecuencia(),
                                       $this->contenido);
        $this->contenido = str_replace('<!-- {{cantidad de participantes}} -->',
                                       $proyecto->getCantidadParticipantes(),
                                       $this->contenido);
        $this->contenido = str_replace('<!-- {{accion}} -->', 'PONER ACCION',
                                       $this->contenido);
        $this->contenido = str_replace('<!-- {{comentarios}} -->',
                                       $proyecto->getComentarios(),
                                       $this->contenido);
        $this->contenido = str_replace('<!-- {{leyenda}} -->',
                                       $proyecto->getLeyenda(), $this->contenido);


        $inicioCiclo    = '<!-- {{inicio.lista}} -->';
        $finCiclo       = '<!-- {{fin.lista}} -->';
        $inicioCicloLEN = strlen($inicioCiclo);
        $finCicloLEN    = strlen($finCiclo);
        foreach($proyecto->getParticipantes() as $participante){
            $inicioCicloPos  = strpos($this->contenido, $inicioCiclo);
            $finCicloPos     = strpos($this->contenido, $finCiclo);
            $textAux         = substr($this->contenido,
                                      $inicioCicloPos + $inicioCicloLEN,
                                      $finCicloPos - $inicioCicloPos - $inicioCicloLEN);
            $textAux         = str_replace('<!-- {{nombre}} -->',
                                           $participante->getNombre(), $textAux);
            $this->contenido = substr_replace($this->contenido, $textAux,
                                              $inicioCicloPos, 0);
        }
        $inicioCicloPos  = strpos($this->contenido, $inicioCiclo);
        $finCicloPos     = strpos($this->contenido, $finCiclo);
        $this->contenido = substr($this->contenido, 0, $inicioCicloPos) . substr($this->contenido,
                                                                       $finCicloPos + $finCicloLEN);
    }

}
