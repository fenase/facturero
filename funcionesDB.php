<?php

class Database{

    private $db;
    var $insert_id;

    /**
     * Constructor. Abre una conexión MySQLi
     * @param type $host
     * @param type $user
     * @param type $pass
     * @param type $db
     */
    function __construct($host = DBHOST, $user = DBUSER, $pass = DBPASS, $db = DBDB){
        $this->db = new mysqli($host, $user, $pass, $db);
        if(mysqli_connect_error()){
            die('imposible conectar a la base de datos: ' . mysqli_connect_error());
        }
    }

    /**
     * Se invoca cuando se pierden todas las referencias al objeto (o al final del script).
     */
    function __destruct(){
        $this->cerrar();
    }

    /**
     * Cierra la conexión abierta.
     * Privada ya que no quiero que queden objetos sin conexión.
     */
    private function cerrar(){
        $this->db->kill($this->db->thread_id);
        $this->db->close();
    }

    /**
     * Ejecuta la consulta en la conexión abierta.
     * @param string $query Consulta
     * @return mixed MYSQLI_RESULT resultado en caso de éxito. BOOL FALSE en caso de falla
     * @todo Ahora, en caso de falla, termina el script con en mensaje de error. Se debería loguear y no salir (que quien llama decida si se termina o no).
     */
    function query($query){
        if(($res = $this->db->query($query)) === FALSE){
            die('error en la query "' . $query . '": ' . $this->db->error);
            return FALSE; //TODO: cambiar die por log.
        }else{
            $this->insert_id = $this->db->insert_id;
            return $res;
        }
    }

    function ping(){
        return $this->db->ping();
    }

    /**
     * Escapa las cadenas para poder insertarlas en la db.
     * @param type $string
     * @return type
     */
    function escape_string($string){
        return $this->db->escape_string($string);
    }

}
