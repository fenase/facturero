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
    function __construct($host = DBHOST, $user = DBUSER, $pass = DBPASS, $db = DBDB, $driver = DBDRIVER){
        $this->thisLink = "$driver:host=$host;dbname=$db";
        $this->thisLinkREDACTED = "$driver::h:$host::u:$user::p:******::d:$db";
        if(!self::$links[$this->thisLinkREDACTED]){
            self::$links[$this->thisLinkREDACTED] = new PDO($this->thisLink, $user, $pass);
            //si no se conecta, tira excepción
            self::$references[$this->thisLinkREDACTED]++;
            $logger = new Logger();
            $logger->log("Conectado a la base de datos $db en $host (Refs[".$this->thisLinkREDACTED."]=".self::$references[$this->thisLinkREDACTED].")");               
            
        }else{
            self::$references[$this->thisLinkREDACTED]++;
            $logger = new Logger();
            $logger->log("Base de datos $db en $host ya conectada. Reutilizando vínculo (Refs[".$this->thisLinkREDACTED."]=".self::$references[$this->thisLink].")");
        }
    }

    /**
     * Se invoca cuando se pierden todas las referencias al objeto (o al final del script).
     * Cierra las conexiones que pierden referencia
     * ¿ES NECESARIO CON PDO?
     */
    function __destruct(){
        self::$references[$this->thisLinkREDACTED]--;
        if(!self::$references[$this->thisLinkREDACTED]){
            $this->cerrar();
        }else{
            $logger = new Logger;
            //uso @ para eliminar errores ya que el destructor se llama al cierre del script. La limpieza puede haber cerrado la conexión antes de tener tiempo de hacerlo explícitamente
            @$logger->log("No se cierra base de datos ya que quedan referencias (Refs[".$this->thisLinkREDACTED."]=".self::$references[$this->thisLinkREDACTED].")");
        }
    }

    /**
     * Cierra la conexión abierta.
     * Privada ya que no quiero que queden objetos sin conexión.
     * ¿ES NECESARIO CON PDO?
     */
    private function cerrar(){
        self::$links[$this->thisLinkREDACTED] = null;
        unset(self::$links[$this->thisLinkREDACTED]);
    }

    /**
     * Ejecuta la consulta en la conexión abierta.
     * @param string $query Consulta a preparar
     * @param array $data arreglo asociativo con los parámetros de la consulta
     * @return boolean exito de la llamada
     */
    function query($query, $data = array()){
        $STH = self::$links[$this->thisLinkREDACTED]->prepare($query);
        $STH->execute($data);
        $this->insert_id = self::$links[$this->thisLinkREDACTED]->lastInsertId();
        $logger = new Logger();
        $logger->log('query exitosa: ' . $STH->queryString . ' con parámetros ' . print_r($data, true));
        return $STH->fetchAll(PDO::FETCH_ASSOC);
        /*
        
        
        if(($res = self::$links[$this->thisLink]->query($query)) === FALSE){
            throw new Exception('error en la query "' . $query . '": ' . self::$links[$this->thisLink]->error);
        }else{
            $this->insert_id = self::$links[$this->thisLink]->insert_id;
            $logger = new Logger();
            $logger->log('query exitosa: ' . $query . '');
            return $res;
        }
         */
    }

    /**
     * Verifica que la conexión esté abierta
     * @return boolean
     * @deprecated no se usa desde PDO
     */
    function ping(){
        trigger_error('ping() is deprecated', E_USER_NOTICE);
        debug_print_backtrace();
        return self::$links[$this->thisLink]->ping();
    }

    /**
     * Escapa las cadenas para poder insertarlas en la db.
     * @param string $string
     * @return type
     * @deprecated no se usa desde PDO
     */
    function escape_string($string){
        trigger_error('escape_string() is deprecated', E_NOTICE);
        debug_print_backtrace();
        return self::$links[$this->thisLink]->escape_string($string);
    }

}
