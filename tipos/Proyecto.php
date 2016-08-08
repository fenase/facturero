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
        if(!self::$db){
            self::$db = new Database();
        }
        if(!$datos){
            //proyecto existente
            $query = "SELECT idproyectos, nombre, frecuencia, cantidadParticipantes, siguienteIndex, comentarios, leyenda "
                    . "FROM proyectos "
                    . "WHERE idproyectos = :id";
            $res   = self::$db->query($query, array('id' => $id));
            if(($row   = $res[0])){
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
        $query = "SELECT u.idUsuarios as id, up.orden, u.user, u.pass, u.ultimoLogin, u.loginenabled, u.verificacion, u.mail, u.nombre "
                . "FROM usuariosenproyecto up "
                . "JOIN usuarios u ON up.idUsuarios = u.idUsuarios "
                . "WHERE up.idproyectos = :id "
                . "ORDER BY up.orden";
        $res   = self::$db->query($query, get_object_vars($this));
        
        return Usuario::crearUsuarios($res);
    }

    /**
     * Guarda el proyecto en la base de datos
     */
    public function guardar(){
        if($this->id === FALSE){
            //nuevo proyecto
            $query = "INSERT INTO proyectos "
                    . "(nombre, frecuencia, cantidadParticipantes, comentarios, leyenda) VALUE "
                    . "(:nombre, :frecuencia, :cantidadParticipantes, :comentarios, :leyenda)";
        }else{
            //actualizar
            $query = "UPDATE proyectos SET "
                    . "nombre = :nombre, "
                    . "frecuencia = :frecuencia, "
                    . "cantidadParticipantes = :cantidadParticipantes, "
                    . "siguienteIndex = :siguienteParticipanteIndex, "
                    . "comentarios = :comentarios, "
                    . "leyenda = :leyenda "
                    . "WHERE idproyectos = :id";
        }
        self::$db->query($query, get_object_vars($this));
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
        $query = "DELETE FROM usuariosenproyecto WHERE idproyectos = ?";
        self::$db->query($query, array($this->id));
        if($this->cantidadParticipantes){
            $data = array();
            $query = "INSERT INTO usuariosenproyecto (idusuarios, idproyectos, orden) values " . $this->listaQueryValuesUsuariosEnProyecto($data);
            //vuelvo a insertar la lista.
            self::$db->query($query, $data);
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
            $donde = $this->siguienteParticipanteIndex;
        }
        $donde %= $this->cantidadParticipantes;
        $usuarioAInsertar = new usuario($idIn);
        array_splice($this->participantes, $donde, 0, Array($usuarioAInsertar));
        //recontruir orden
        if($donde <= $this->siguienteParticipanteIndex){
            //si inserté antes del siguiente, se movió el siguiente. No es necesario tomar módulo ya que tengo al menos uno más que antes.
            $this->siguienteParticipanteIndex++;
        }
        foreach($this->participantes as $participante){
            if($participante->getId() == $idIn){
                //genero orden para el participante recién ingresado
                $participante->setOrden($donde);
            }
            if($participante->getOrden() >= $donde){
                //muevo los siguientes para más adelante
                $participante->setOrden($participante->getOrden() + 1);
            }
        }
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
        foreach($res as $row){
            $proyectos[] = new Proyecto($row['idproyectos']);
        }
        return $proyectos;
    }

    /**
     * Muestra los campos posibles para una acción determinada para los proyectos
     * @param int $cuales PROY_FIELD_SHOW, PROY_FIELD_EDIT, PROY_FIELD_CREATE
     * @return Array
     */
    public static function obtenerCamposVisibles($cuales = 07){
        //nueva db por ser static
        $l = new Database();
        $query = "SELECT orden, nombreColumnaDB, nombreMostrar FROM camposproyecto where mostrarEn & :cuales <> 0";
        return $l->query($query, array('cuales' => $cuales));
    }

    /**
     * Auxiliar de guardarParticipantes. Crea el string con los valores para ingresar en la query de almacenamiento de valores.
     * @param OUT Array $data Arreglo de datos para PDO
     * @return string
     */
    private function listaQueryValuesUsuariosEnProyecto(&$data){
        $i   = 0;
        $res = '';
        do{
            $res .= '(';
            $res .= ":idParticipante{$i}, ";
            $res .= ":idProyecto, ";
            $res .= ":ordenParticipante{$i} ";
            $res .= ')';
            $data['idParticipante'.$i] = $this->participantes[$i]->getId();
            $data['idProyecto'] = $this->id;
            $data['ordenParticipante'.$i] = $this->participantes[$i]->getOrden();
            $i++;
        }while($i < $this->cantidadParticipantes && $res .= ', ');
        return $res;
    }

}
