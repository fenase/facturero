<?php
/**
 * Controlador de base de datos
 * @package backEnd
 */

/**
 * controla conexiones hacia la base de datos. Puede manejar varias conexiones al mismo tiempo (distintos usuarios, schemas, etc.)
 * @package backEnd/database
 */
class Database{

    /** @var int almacena el último id de un insert sobre PK con autoincrement */
    var $insert_id;
    /** @var array todas las conexiones abiertas en dicionario sobre los datos que las distinghen */
    private static $links;
    /** @var string clave dentro del diccionario $links de la conexión referenciada por esta instabcia de Database */
    private $thisLink;
    /** @var string clave dentro del diccionario $links de la conexión referenciada por esta instabcia de Database CON PASSWORD CENSURADA LARA LOG */
    private $thisLinkREDACTED;
    /** @var int Cuenta la cantidad de instancias abiertas existen para cada conexión. Util para el destructor */
    private static $references;

    /**
     * Constructor. Abre una conexión MySQLi
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $db
     */
    function __construct($host = DBHOST, $user = DBUSER, $pass = DBPASS, $db = DBDB){
        $this->thisLink = "h:$host::u:$user::p:$pass::d:$db";
        $this->thisLinkREDACTED = "h:$host::u:$user::p:******::d:$db";
        if(!self::$links[$this->thisLink]){
            self::$links[$this->thisLink] = new mysqli($host, $user, $pass, $db);
            if(mysqli_connect_error()){
                throw new Exception('imposible conectar a la base de datos: ' . mysqli_connect_error());
            }else{
                self::$references[$this->thisLink]++;
                $logger = new Logger();
                $logger->log("Conectado a la base de datos $db en $host (id: ".self::$links[$this->thisLink]->thread_id.") (Refs[".$this->thisLinkREDACTED."]=".self::$references[$this->thisLink].")");               
            }
        }else{
            self::$references[$this->thisLink]++;
            $logger = new Logger();
            $logger->log("Base de datos $db en $host ya conectada. Reutilizando vínculo (Refs[".$this->thisLinkREDACTED."]=".self::$references[$this->thisLink].")");
        }
    }

    /**
     * Se invoca cuando se pierden todas las referencias al objeto (o al final del script).
     * Cierra las conexiones que pierden referencia
     */
    function __destruct(){
        self::$references[$this->thisLink]--;
        if(!self::$references[$this->thisLink]){
            $this->cerrar();
        }else{
            $logger = new Logger;
            //uso @ para eliminar errores ya que el destructor se llama al cierre del script. La limpieza puede haber cerrado la conexión antes de tener tiempo de hacerlo explícitamente
            @$logger->log("No se cierra base de datos (id ".self::$links[$this->thisLink]->thread_id.") ya que quedan referencias (Refs[".$this->thisLinkREDACTED."]=".self::$references[$this->thisLink].")");
        }
    }

    /**
     * Cierra la conexión abierta.
     * Privada ya que no quiero que queden objetos sin conexión.
     */
    private function cerrar(){
        @self::$links[$this->thisLink]->kill($tid = self::$links[$this->thisLink]->thread_id);
        @self::$links[$this->thisLink]->close();
        unset(self::$links[$this->thisLink]);
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

    /**
     * Verifica que la conexión esté abierta
     * @return boolean
     */
    function ping(){
        return self::$links[$this->thisLink]->ping();
    }

    /**
     * Escapa las cadenas para poder insertarlas en la db.
     * @param string $string
     * @return type
     */
    function escape_string($string){
        return self::$links[$this->thisLink]->escape_string($string);
    }

}
