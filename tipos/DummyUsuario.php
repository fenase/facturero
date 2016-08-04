<?php
/**
 * contiene clase DummyUsuario
 */

/**
 * Usuario genérico para realizar filtrado dentro de arreglos de usuarios
 * @author FedSeckel
 */
class DummyUsuario extends Usuario{

    /**
     * Crea el dummy
     * @param $identificacion dato a cargar
     * @param int $tipoID tipo de dato a cargar (nombre, id)
     */
    public function __construct($identificacion, $tipoID = USER_SEARCH_TIPE_ID){
        $this->id   = NULL;
        $this->user = NULL;
        if($tipoID == USER_SEARCH_TIPE_ID){
            $this->id = $identificacion;
        }
        if($tipoID == USER_SEARCH_TIPE_USER){
            $this->user = $identificacion;
        }
    }

    /**
     * Verifica si un usuario determinado está identificado con $id
     * @param Usuario $id
     */
    public function hasIDEqual($id){
        return $id->id == $this->id;
    }

    /**
     * Verifica si un usuario determinado está identificado con $id
     * @param Usuario $id
     */
    public function hasIDNotEqual($id){
        return $id->id != $this->id;
    }

}
