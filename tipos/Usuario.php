<?php

/**
 * Clase usuario
 *
 * @author fedseckel
 */
class Usuario{

    private $id;
    private $user;
    private $pass;
    private $ultimoLogin;
    private $loginEnabled;
    private $verificacion;
    private $mail;
    private $nombre;
    private $orden; //sólo tiene sentido si el usuario pertenece a un proyecto
    static private $db;

    function __construct($identificacion, $tipoID = USER_SEARCH_TIPE_ID,
                         $datos = NULL){
        if(!$this->db || !$this->db->ping()){
            $this->db = new Database();
        }
        if($tipoID != USER_MANUAL_DEFINE){
            if($tipoID == USER_SEARCH_TIPE_ID){
                $tipobusquedatext = 'idusuarios';
            }elseif($tipoID == USER_SEARCH_TIPE_USER){
                $tipobusquedatext = 'user';
            }else{
                throw new Exception('método de búsqueda de usuario no válido');
            }
            $query = "SELECT idusuarios, user, pass, ultimoLogin, loginenabled, verificacion, mail, nombre "
                    . "FROM usuarios "
                    . "WHERE $tipobusquedatext = $identificacion";
            $res   = $this->db->query($query);
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
                throw new Exception("usuario (".$identificacion.") no encontrado (usando ".$tipobusquedatext.")");
            }
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

    public function setUltimoLogin($ultimoLoginIN){
        $this->ultimoLogin = $ultimoLoginIN;
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
     * Crea masivamente objeto usuario desde usuarios obtenidos desde la base de datos
     * @param array $conjunto conjunto de datos con los que crear usuarios
     * @return array(usuario)
     */
    public static function crearUsuarios($conjunto){
        $usuarios = array();
        foreach($conjunto as $datos){
            $usuarios[] = new Usuario(NULL, USER_MANUAL_DEFINE, $datos);
        }
        return $usuarios;
    }

    /**
     * Verifica que el usuario exista
     * @return boolean
     */
    public function existe(){
        $query = "SELECT 1 FROM usuarios WHERE idusuario = " . $this->id;
        $res   = $this->db->query($query);
        return ($res->num_rows > 0);
    }

    /**
     * Actualiza el usuario actual en la db
     */
    public function guardar(){
        if($this->existe()){
            $query = "UPDATE usuarios "
                    . "SET user = " . $this->user
                    . ", pass = " . $this->pass
                    . ", ultimoLogin = " . $this->ultimoLogin
                    . ", loginenabled = " . $this->loginEnabled
                    . ", verificacion = " . $this->verificacion
                    . ", mail = " . $this->mail
                    . ", nombre = " . $this->nombre
                    . "WHERE idusuario = " . $this->id;
            $this->db->query($query);
        }else{
            $query    = "INSERT INTO usuarios (user, pass, ultimoLogin, loginenabled, verificacion, mail, nombre) VALUE ("
                    . $this->user . ", " . $this->pass . ", " . $this->ultimoLogin . ", " . $this->loginEnabled . ", "
                    . $this->verificacion . ", " . $this->mail . ", " . $this->nombre . ")";
            $this->db->query($query);
            $this->id = $this->db->insert_id;
        }
    }

    public static function sacarHuecosOrden(&$list){
        $ultimoOrden = 1;
        usort($list, array('usuario', 'compararOrden')); //me aseguro que esté ordenado
        while($ultimoOrden <= count($list)){
            $list[$ultimoOrden - 1]->setOrden($ultimoOrden);
            $ultimoOrden++;
        }
    }

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
        $res   = $this->db->query($query);
        while($row   = $res->fetch_assoc()){
            $ret[] = array('id' => $row['idproyectos'], 'nombre' => $row['nombre']);
        }
        return $ret;
    }

}
