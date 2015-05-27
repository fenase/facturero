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
            throw new Exception('imposible conectar a la base de datos: ' . mysqli_connect_error());
        }else{
            $logger = new Logger();
            $logger->log("Conectado a la base de datos $db en $host (id: ".$this->db->thread_id.")");
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
        $this->db->kill($tid = $this->db->thread_id);
        $this->db->close();
        $logger = new Logger();
        $logger->log("Cerrada la conexión a la base de datos id $tid");
    }

    /**
     * Ejecuta la consulta en la conexión abierta.
     * @param string $query Consulta
     * @return mixed MYSQLI_RESULT resultado en caso de éxito. BOOL FALSE en caso de falla
     */
    function query($query){
        if(($res = $this->db->query($query)) === FALSE){
            throw new Exception('error en la query "' . $query . '": ' . $this->db->error);
        }else{
            $this->insert_id = $this->db->insert_id;
            $logger = new Logger();
            $logger->log('query exitosa: ' . $query . '');
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
