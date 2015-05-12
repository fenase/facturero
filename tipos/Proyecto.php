<?php

/**
 * Clase proyecto
 * 
 * @author FedSeckel
 */
class Proyecto{

    private $id;
    private $nombre;
    private $frecuencia;
    private $cantidadParticipantes;
    private $participantes;
    private $siguienteParticipanteIndex;
    private $comentarios;
    private $leyenda;
    private static $db;

    function __construct($id, $datos = NULL){
        if(!$this->db || !$this->db->ping()){
            $this->db = new Database();
        }
        if(!$datos){
            //proyecto existente
            $query = "SELECT idproyectos, nombre, frecuencia, cantidadParticipantes, siguienteIndex, comentarios, leyenda "
                    . "FROM proyectos "
                    . "WHERE idproyectos = $id";
            $res   = $this->db->query($query);
            if(($row   = $res->fetch_assoc())){
                $this->id                         = $id;
                $this->nombre                     = $row['nombre'];
                $this->frecuencia                 = $row['frecuencia'];
                $this->cantidadParticipantes      = $row['cantidadParticipantes'];
                $this->siguienteParticipanteIndex = $row['siguienteIndex'];
                $this->comentarios                = $row['comentarios'];
                $this->leyenda                    = $row['leyenda'];
            }else{
                throw new Exception("proyecto (".$id.") no encontrado");
            }

            $this->participantes = $this->participantesDelProyecto();
        }else{
            //usuario nuevo
            $this->id                         = FALSE;
            $this->nombre                     = $datos['nombre'];
            $this->frecuencia                 = $datos['frecuencia'];
            $this->cantidadParticipantes      = 0;
            $this->siguienteParticipanteIndex = 1;
            $this->comentarios                = $datos['comentarios'];
            $this->leyenda                    = $datos['leyenda'];
            $this->participantes              = array();
        }
    }

    //<editor-fold>
    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getFrecuencia(){
        return $this->frecuencia;
    }

    public function getCantidadParticipantes(){
        return $this->cantidadParticipantes;
    }

    public function getParticipantes(){
        return $this->participantes;
    }

    public function getSiguienteParticipanteIndex(){
        return $this->siguienteParticipanteIndex;
    }

    public function getComentarios(){
        return $this->comentarios;
    }

    public function getLeyenda(){
        return $this->leyenda;
    }

    public function setNombre($nombreIN){
        $this->nombre = $nombreIN;
    }

    public function setFrecuencia($frecuenciaIN){
        $this->frecuencia = $frecuenciaIN;
    }

    public function setParticipantes($participantesIN){
        $this->participantes = $participantesIN;
    }

    public function setSiguienteParticipanteIndex($i){
        $this->siguienteParticipanteIndex = $i;
    }

    public function setComentarios($comentariosIN){
        $this->comentarios = $comentariosIN;
    }

    public function setLeyenda($leyendaIN){
        $this->leyenda = $leyendaIN;
    }

    //</editor-fold>Getters and Setters

    /**
     * Crea los usuarios participantes del priyecto actual
     * @return array(usuario)
     */
    private function participantesDelProyecto(){
        $query = "SELECT u.idUsuarios, up.orden, u.user, u.pass, u.ultimoLogin, u.loginenabled, u.verificacion, u.mail, u.nombre "
                . "FROM usuariosenproyecto up "
                . "JOIN usuarios u ON up.idUsuarios = u.idUsuarios "
                . "WHERE up.idproyectos = " . $this->id;
        $res   = $this->db->query($query);
        $datos = array();
        while(($row   = $res->fetch_assoc())){
            $dato['id']           = $row['idUsuarios'];
            $dato['user']         = $row['user'];
            $dato['pass']         = $row['pass'];
            $dato['ultimoLogin']  = $row['ultimoLogin'];
            $dato['loginEnabled'] = $row['loginenabled'];
            $dato['verificacion'] = $row['verificacion'];
            $dato['mail']         = $row['mail'];
            $dato['nombre']       = $row['nombre'];
            $dato['orden']        = $row['orden'];
            $datos[]              = $dato;
        }
        return Usuario::crearUsuarios($datos);
    }

    /**
     * Guarda el proyecto en la base de datos
     */
    public function guardar(){
        if($this->id === FALSE){
            //nuevo proyecto
            $query = "INSERT INTO proyectos "
                    . "(nombre, frecuencia, cantidadParticipantes, comentarios, leyenda) VALUE "
                    . "("
                    . $this->nombre . ", "
                    . $this->frecuencia . ", "
                    . $this->cantidadParticipantes . ", "
                    . $this->comentarios . ", "
                    . $this->leyenda
                    . ")";
        }else{
            //actualizar
            $query = "UPDATE proyectos SET "
                    . "nombre = " . $this->nombre
                    . "frecuencia = " . $this->frecuencia
                    . "cantidadParticipantes = " . $this->cantidadParticipantes
                    . "comentarios = " . $this->comentarios
                    . "leyenda = " . $this->leyenda
                    . "WHERE id = " . $this->id;
        }
        $this->db->query($query);
        if($this->id === FALSE){
            $this->id = $this->db->insert_id;
        }
        $this->guardarParticipantes();
    }

    private function guardarParticipantes(){
        //borro todos los usuarios
        $query = "DELETE FROM usuariosenproyecto WHERE idproyectos = " . $this->id;
        $this->db->query($query);
        $query = "INSERT INTO usuariosenproyecto (idusuarios, idproyectos, orden) values " . $this->listaQueryValuesUsuariosEnProyecto();
        //vuelvo a insertar la lista.
        $this->db->query($query);
    }

    /**
     * Inserta un usuario en la lista de usuarios
     * @param int $id identificación del usuario
     * @param int $donde Posición a insertar. Si vacío: justo antes del actual.
     */
    public function IngresarParticipante($id, $donde = NULL){
        //decido si obtuve valor de ubicación. Si no, por defecto
        if(is_null($donde)){
            $donde = $this->siguienteParticipanteIndex - 1;
        }
        $donde %= $this->cantidadParticipantes;
        array_splice($this->participantes, $this->siguienteParticipanteIndex, 0, new Usuario($id));
        $this->cantidadParticipantes = count($this->participantes);
    }

    /**
     * Elimina un participante de la lista de proyectos
     * @param int $id participante a eliminar
     */
    public function sacarParticipante($id){
        $this->participantes = array_filter($this->participantes,
                                                array(new NumericComparisonFilter($id), 'isEqual'));
        Usuario::sacarHuecosOrden($this->participantes);
        $this->cantidadParticipantes = count($this->participantes);
    }

    /**
     * Carga todos los proyectos 
     * @return Array(proyecto)
     */
    public static function todosLosProyectos(){
        //nueva db por ser static
        $l         = new Database();
        $query     = "SELECT distinct(idproyectos) as idproyectos FROM proyectos";
        $res       = $l->query($query);
        $proyectos = array();
        while(($row      = $res->fetch_assoc())){
            $proyectos[] = new Proyecto($row['idproyectos']);
        }
        return $proyectos;
    }

    private function listaQueryValuesUsuariosEnProyecto(){
        $i   = 0;
        $res = '';
        do{
            $res .= '(';
            $res .= $this->participantes[$i]->id . ', ';
            $res .= $this->id . ', ';
            $res .= $this->participantes[$i]->orden;
            $res .= ')';
            $i++;
        }while($i < count($this->cantidadParticipantes) && $res .= ', ');
    }

}
