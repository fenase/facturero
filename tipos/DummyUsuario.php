<?php

/**
 * Description of DummyUsuario
 *
 * @author FedSeckel
 */
class DummyUsuario extends Usuario{

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
