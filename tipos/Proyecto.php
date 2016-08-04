<?php
/**
 * Contiene clase proyecto
 * @package Tipos de datos
 */

/**
 * Clase Proyecto
 * @package Tipos de datos
 * @author FedSeckel
 */
class Proyecto{

    /** @var int identificación del proyecto */
    private $id;
    /** @var string nombre fantasía del proyecto */
    private $nombre;
    /** @var mixed frecuencia (cada cuanto se debe activar) el proyecto */
    private $frecuencia;
    /** @var unsigned int cuántos participantes tiene el proyecto */
    private $cantidadParticipantes;
    /** @var Usuario[] participantes del proyecto */
    private $participantes;
    /** @var int orden del siguiente participante */
    private $siguienteParticipanteIndex;
    /** var string comentarios */
    private $comentarios;
    /** var string texto libre. Breve descripción del proyecto */
    private $leyenda;
    /** @var mysqli conexión a la base de datos */
    private static $db;

    /**
     * Constructos de la clase. Si se reciben datos en $datos se crea el proyecto usando los mismos.
     * Caso contrario, se crea el objeto con el resultado de buscar el $id en la base de datos
     * @param int $id
     * @param mixed[] $datos
     * @throws Exception en caso de no encontrar id válida
     */
    function __construct($id, $datos = NULL){
        if(!self::$db || !self::$db->ping()){
            self::$db = new Database();
        }
        if(!$datos){
            //proyecto existente
            $query = "SELECT idproyectos, nombre, frecuencia, cantidadParticipantes, siguienteIndex, comentarios, leyenda "
                    . "FROM proyectos "
                    . "WHERE idproyectos = $id";
            $res   = self::$db->query($query);
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
            $res->free();

            $this->participantes = $this->participantesDelProyecto();
        }else{
            //proyecto nuevo
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
        Usuario::sacarHuecosOrden($participantesIN, TRUE);
        $this->participantes = $participantesIN;
        $this->cantidadParticipantes = count($this->participantes);
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
     * @return Usuario[]
     */
    private function participantesDelProyecto(){
        $query = "SELECT u.idUsuarios, up.orden, u.user, u.pass, u.ultimoLogin, u.loginenabled, u.verificacion, u.mail, u.nombre "
                . "FROM usuariosenproyecto up "
                . "JOIN usuarios u ON up.idUsuarios = u.idUsuarios "
                . "WHERE up.idproyectos = " . $this->id . " "
                . "ORDER BY up.orden";
        $res   = self::$db->query($query);
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
        $res->free();
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
                    . "'" . $this->nombre . "', "
                    . "'" . $this->frecuencia . "', "
                    . "'" . $this->cantidadParticipantes . "', "
                    . "'" . $this->comentarios . "', "
                    . "'" . $this->leyenda
                    . "'" . ")";
        }else{
            //actualizar
            $query = "UPDATE proyectos SET "
                    . "nombre = '" . $this->nombre . "', "
                    . "frecuencia = '" . $this->frecuencia . "', "
                    . "cantidadParticipantes = '" . $this->cantidadParticipantes . "', "
                    . "comentarios = '" . $this->comentarios . "', "
                    . "leyenda = '" . $this->leyenda . "' "
                    . "WHERE idproyectos = '" . $this->id . "'";
        }
        self::$db->query($query);
        if($this->id === FALSE){
            $this->id = self::$db->insert_id;
        }
        $this->guardarParticipantes();
    }

    /**
     * auxiliar de guardar. Se encarga de almecenar o actualizar los participantes del proyecto.
     */
    private function guardarParticipantes(){
        //borro todos los usuarios
        $query = "DELETE FROM usuariosenproyecto WHERE idproyectos = " . $this->id;
        self::$db->query($query);
        if($this->cantidadParticipantes){
            $query = "INSERT INTO usuariosenproyecto (idusuarios, idproyectos, orden) values " . $this->listaQueryValuesUsuariosEnProyecto();
            //vuelvo a insertar la lista.
            self::$db->query($query);
        }
    }

    /**
     * Inserta un usuario en la lista de usuarios
     * @param int $idIn identificación del usuario
     * @param int $donde Posición a insertar. Si vacío: justo antes del actual.
     */
    public function IngresarParticipante($idIn, $donde = NULL){
        //decido si obtuve valor de ubicación. Si no, por defecto
        if(is_null($donde)){
            $donde = $this->siguienteParticipanteIndex - 1;
        }
        $donde %= $this->cantidadParticipantes;
        array_splice($this->participantes, $donde, 0, new Usuario($idIn));
        $this->cantidadParticipantes = count($this->participantes);
    }

    /**
     * Elimina un participante de la lista de proyectos
     * @param int $idIn participante a eliminar
     */
    public function sacarParticipante($idIn){
        $this->participantes = array_filter($this->participantes,
                                                array(new DummyUsuario($idIn), 'hasIDNotEqual'));
        Usuario::sacarHuecosOrden($this->participantes);
        $this->cantidadParticipantes = count($this->participantes);
    }

    /**
     * Carga todos los proyectos 
     * @return Proyecto[]
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
        $res->free();
        return $proyectos;
    }

    /**
     * Auxiliar de guardarParticipantes. Crea el string con los valores para ingresar en la query de almacenamiento de valores.
     * @return string
     */
    private function listaQueryValuesUsuariosEnProyecto(){
        $i   = 0;
        $res = '';
        do{
            $res .= '(';
            $res .= $this->participantes[$i]->getId() . ', ';
            $res .= $this->id . ', ';
            $res .= $this->participantes[$i]->getOrden();
            $res .= ')';
            $i++;
        }while($i < $this->cantidadParticipantes && $res .= ', ');
        return $res;
    }

}
