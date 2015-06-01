<?php

class Database{

    var $insert_id;
    private static $links;
    private $thisLink;
    private static $references;

    /**
     * Constructor. Abre una conexión MySQLi
     * @param type $host
     * @param type $user
     * @param type $pass
     * @param type $db
     */
    function __construct($host = DBHOST, $user = DBUSER, $pass = DBPASS, $db = DBDB){
        $this->thisLink = "h:$host::u:$user::p:$pass::d:$db";
        if(!self::$links[$this->thisLink]){
            self::$links[$this->thisLink] = new mysqli($host, $user, $pass, $db);
            if(mysqli_connect_error()){
                throw new Exception('imposible conectar a la base de datos: ' . mysqli_connect_error());
            }else{
                self::$references++;
                $logger = new Logger();
                $logger->log("Conectado a la base de datos $db en $host (id: ".self::$links[$this->thisLink]->thread_id.") (Refs=".self::$references.")");               
            }
        }else{
            self::$references++;
            $logger = new Logger();
            $logger->log("Base de datos $db en $host ya conectada. Reutilizando vínculo (Refs=".self::$references.")");
        }
    }

    /**
     * Se invoca cuando se pierden todas las referencias al objeto (o al final del script).
     */
    function __destruct(){
        self::$references--;
        if(!self::$references){
            $this->cerrar();
        }else{
            $logger = new Logger;        
            $logger->log("No se cierra base de datos ya que quedan referencias (Refs=".self::$references.")");
        }
    }

    /**
     * Cierra la conexión abierta.
     * Privada ya que no quiero que queden objetos sin conexión.
     */
    private function cerrar(){
        @self::$links[$this->thisLink]->kill($tid = self::$links[$this->thisLink]->thread_id);
        @self::$links[$this->thisLink]->close();
        $logger = new Logger();
        $logger->log("Cerrada la conexión a la base de datos id $tid");
    }

    /**
     * Ejecuta la consulta en la conexión abierta.
     * @param string $query Consulta
     * @return mixed MYSQLI_RESULT resultado en caso de éxito. BOOL FALSE en caso de falla
     */
    function query($query){
        if(($res = self::$links[$this->thisLink]->query($query)) === FALSE){
            throw new Exception('error en la query "' . $query . '": ' . self::$links[$this->thisLink]->error);
        }else{
            $this->insert_id = self::$links[$this->thisLink]->insert_id;
            $logger = new Logger();
            $logger->log('query exitosa: ' . $query . '');
            return $res;
        }
    }

    function ping(){
        return self::$links[$this->thisLink]->ping();
    }

    /**
     * Escapa las cadenas para poder insertarlas en la db.
     * @param type $string
     * @return type
     */
    function escape_string($string){
        return self::$links[$this->thisLink]->escape_string($string);
    }

}
