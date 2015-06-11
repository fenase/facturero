<?php

/**
 * Clase usuario
 * @package Tipos de datos
 * @author fedseckel
 */
class Usuario{

    /** @var int identificación del usuario */
    private $id;
    /** @var string username */
    private $user;
    /** @var string hash de la contraseña del usuario */
    private $pass;
    /** @var string cuándo ingresó el usuario por última vez */
    private $ultimoLogin;
    /** @var mixed usuario habilitado? */
    private $loginEnabled;
    /** @var mixed usuario verificado? */
    private $verificacion;
    /** @var string dirección de mail del usuario */
    private $mail;
    /** @var string nombre de la persona representada por el usuario */
    private $nombre;
    /** @var int Orden (sólo tiene sentido si el usuario pertenece a un proyecto) */
    private $orden;
    /** @var mysqli conexión a la base de datos */
    static private $db;

    /**
     * Constructor de la clase
     * Si $tipoID = USER_SEARCH_TIPE_ID, crea el objeto buscando en la base de datos la $identificacion en el campo ID del usuario
     * Si $tipoID = USER_SEARCH_TIPE_USER, crea el objeto buscando en la base de datos la $identificacion en el campo username del usuario
     * Si $tipoID = USER_MANUAL_DEFINE, crea el objeto de acuerdo a lo definido en $datos
     * @param mixed $identificacion
     * @param int $tipoID
     * @param array(mixed) $datos
     * @throws Exception
     */
    function __construct($identificacion, $tipoID = USER_SEARCH_TIPE_ID,
                         $datos = NULL){
        if(!self::$db || !self::$db->ping()){
            self::$db = new Database();
        }
        if($tipoID != USER_MANUAL_DEFINE){
            if($tipoID == USER_SEARCH_TIPE_ID){
                $tipobusquedatext = 'idusuarios';
            }elseif($tipoID == USER_SEARCH_TIPE_USER){
                $tipobusquedatext = 'user';
                $identificacion   = "'" . $identificacion . "'";
            }else{
                throw new Exception('método de búsqueda de usuario no válido');
            }
            $query = "SELECT idusuarios, user, pass, ultimoLogin, loginenabled, verificacion, mail, nombre "
                    . "FROM usuarios "
                    . "WHERE $tipobusquedatext = $identificacion";
            $res   = self::$db->query($query);
            if(($datos = $res->fetch_assoc())){
                $this->id           = $datos['idusuarios'];
                $this->user         = $datos['user'];
                $this->pass         = $datos['pass'];
                $this->ultimoLogin  = $datos['ultimoLogin'];
                $this->loginEnabled = $datos['loginenabled'];
                $this->verificacion = $datos['verificacion'];
                $this->mail         = $datos['mail'];
                $this->nombre       = $datos['nombre'];
                $this->orden        = NULL;
            }else{
                if($tipoID == USER_SEARCH_TIPE_ID){
                    //si estoy buscando por ID no puede nunca faltar un usuario. Que falte es falla grave.
                    throw new Exception("usuario (" . $identificacion . ") no encontrado (usando " . $tipobusquedatext . ")");
                }else{
                    //por nombre
                    $logger   = new Logger();
                    $logger->log("usuario (" . $identificacion . ") no encontrado (usando " . $tipobusquedatext . ")",
                                 ERROR_LEVEL_INFO);
                    $this->id = FALSE;
                }
            }
            $res->free();
        }else{
            $this->id           = $datos['id'];
            $this->user         = $datos['user'];
            $this->pass         = $datos['pass'];
            $this->ultimoLogin  = $datos['ultimoLogin'];
            $this->loginEnabled = $datos['loginEnabled'];
            $this->verificacion = $datos['verificacion'];
            $this->mail         = $datos['mail'];
            $this->nombre       = $datos['nombre'];
            $this->orden        = $datos['orden'];
        }
    }

    //<editor-fold>
    public function getId(){
        return $this->id;
    }

    public function getUser(){
        return $this->user;
    }

    public function getPass(){
        return $this->pass;
    }

    public function getUltimoLogin(){
        return $this->ultimoLogin;
    }

    public function getUltimoLoginTimestamp(){
        return strtotime($this->ultimoLogin);
    }

    public function getLoginEnabled(){
        return $this->loginEnabled;
    }

    public function getVerificacion(){
        return $this->verificacion;
    }

    public function getMail(){
        return $this->mail;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getOrden(){
        return $this->orden;
    }

    public function setId($idIN){
        $this->id = $idIN;
    }

    public function setUser($userIN){
        $this->user = $userIN;
    }

    public function setPass($passIN){
        $this->pass = $passIN;
    }

    public function setUltimoLogin($ultimoLoginIN = NULL){
        if(is_null($ultimoLoginIN)){
            $ultimoLoginIN = date('Y-m-d H:i:s');
        }
        $this->ultimoLogin = $ultimoLoginIN;
    }

    public function setUltimoLoginTimestamp($timestamp = NULL){
        if(is_null($timestamp)){
            $timestamp = time();
        }
        $this->ultimoLogin = date('Y-m-d H:i:s', $timestamp);
    }

    public function setLoginEnabled($loginEnabledIN){
        $this->loginEnabled = $loginEnabledIN;
    }

    public function setVerificacion($verificacionIN){
        $this->verificacion = $verificacionIN;
    }

    public function setMail($mailIN){
        $this->mail = $mailIN;
    }

    public function setNombre($nombreIN){
        $this->nombre = $nombreIN;
    }

    public function setOrden($ordenIN){
        $this->orden = $ordenIN;
    }

    //</editor-fold>Getters and Setters

    /**
     * Crea masivamente objeto usuario desde usuarios obtenidos desde la base de datos o desde los datos. Ver más info en el contructor
     * @param array $conjunto conjunto de datos con los que crear usuarios
     * @param int $tipoID igual que en el constructor de la clase
     * @return array(usuario)
     */
    public static function crearUsuarios($conjunto, $tipoID = USER_MANUAL_DEFINE){
        $usuarios = array();
        foreach($conjunto as $dato){
            if($tipoID == USER_MANUAL_DEFINE){
                $usuarios[] = new Usuario(NULL, USER_MANUAL_DEFINE, $dato);
            }else{
                $usuarios[] = new Usuario($dato, $tipoID);
            }
        }
        return $usuarios;
    }

    /**
     * Verifica que el usuario exista
     * @return boolean
     */
    public function existe(){
        $query = "SELECT 1 FROM usuarios WHERE idusuarios = " . $this->id;
        $res   = self::$db->query($query);
        $ret   = ($res->num_rows > 0);
        $res->free();
        return $ret;
    }

    /**
     * Actualiza el usuario actual en la db
     */
    public function guardar(){
        if($this->existe()){
            $query = "UPDATE usuarios "
                    . "SET user = '" . $this->user . "'"
                    . ", pass = '" . $this->pass . "'"
                    . ", ultimoLogin = '" . $this->ultimoLogin . "'"
                    . ", loginenabled = '" . $this->loginEnabled . "'"
                    . ", verificacion = '" . $this->verificacion . "'"
                    . ", mail = '" . $this->mail . "'"
                    . ", nombre = '" . $this->nombre . "'"
                    . "WHERE idusuarios = " . $this->id;
            self::$db->query($query);
        }else{
            $query    = "INSERT INTO usuarios (user, pass, ultimoLogin, loginenabled, verificacion, mail, nombre) VALUE ('"
                    . $this->user . ", '" . $this->pass . "', '" . $this->ultimoLogin . "', '" . $this->loginEnabled . "', '"
                    . $this->verificacion . "', '" . $this->mail . "', '" . $this->nombre . "')";
            self::$db->query($query);
            $this->id = self::$db->insert_id;
        }
    }

    /**
     * Ordena los usuarios por su orden y aplana los valores de orden al volverlos consecutivos comenzando desde 1
     * @param array(usuario) $list
     * @param boolean $sorted está ordenada la lista. Si ya lo está, no se vuelve a ordenar
     */
    public static function sacarHuecosOrden(&$list, $sorted = FALSE){
        $ultimoOrden = 1;
        if(!$sorted){
            //me aseguro que esté ordenado
            usort($list, array('usuario', 'compararOrden'));
        }else{
            //recrear llaves del diccionario
            $tempArrr = $list;
            unset($list);
            foreach($tempArrr as $value){
                $list[] = $value;
            }
        }
        while($ultimoOrden <= count($list)){
            $list[$ultimoOrden - 1]->setOrden($ultimoOrden);
            $ultimoOrden++;
        }
    }

    /**
     * Compara 2 usuarios teniendo en cuenta su campo orden
     * @param usuario $a
     * @param usuario $b
     * @return int 0 si son iguales; -1 si $a<$b, 1 en caso contrario
     */
    public static function compararOrden($a, $b){
        return ( ($a->getOrden() == $b->getOrden()) ? 0 :
                        (($a->getOrden() < $b->getOrden()) ? -1 : 1) );
    }

    /**
     * Obtiene los proyectos asignados a un usuario
     * @return array(int, string) arreglo de <id, nombre> de proyecto
     */
    public function proyectos(){
        $ret   = array();
        $query = "SELECT up.idproyectos, p.nombre "
                . "FROM usuariosenproyecto up "
                . "JOIN proyectos p ON p.idproyectos = up.idproyectos "
                . "WHERE up.idusuarios = " . $this->id . " "
                . "ORDER BY p.nombre ASC";
        $res   = self::$db->query($query);
        while($row   = $res->fetch_assoc()){
            $ret[] = array('id' => $row['idproyectos'], 'nombre' => $row['nombre']);
        }
        $res->free();
        return $ret;
    }

    /**
     * Carga todos los usuarios 
     * @return Array(usuario)
     */
    public static function todosLosUsuarios(){
        //nueva db por ser static
        $l        = new Database();
        $query    = "SELECT distinct(idusuarios) as idusuarios FROM usuarios";
        $res      = $l->query($query);
        $usuarios = array();
        while(($row      = $res->fetch_assoc())){
            $usuarios[] = new Usuario($row['idusuarios']);
        }
        $res->free();
        return $usuarios;
    }

}
