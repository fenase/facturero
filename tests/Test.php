<?php

class TestOfUsuario extends UnitTestCase{
    
    private $usuario;
    private $datos;
    
    function __construct(){
        $esUnaPruebaEntoncesIgnorarSesiones = TRUE;
        chdir(dirname(dirname(__FILE__)));
        include 'prepend.php';
    }
    
    function setUp(){
        $this->datos   = array(
            'id'           => 9,
            'user'         => 'fsec',
            'pass'         => 'contra',
            'ultimoLogin'  => '2015-05-01 03:19:59',
            'loginEnabled' => 1,
            'verificacion' => 'veri',
            'mail'         => 'mail@server.com',
            'nombre'       => 'este es mi nombre',
            'orden'        => '3'
        );
        $this->usuario = new usuario(NULL, USER_MANUAL_DEFINE, $this->datos);
    }

    //<editor-fold>
    function test_constructFromData(){
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
    }
    
    function testGetSetId(){
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
        
        $this->usuario->setId(84);
        
        $this->assertEqual($this->usuario->getId(), 84);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
    }
    
    function testGetSetUser(){
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
        
        $this->usuario->setUser('pepito');
        
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), 'pepito');
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
    }
    
    function testGetSetPass(){
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
        
        $this->usuario->setPass('pepito');
        
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), 'pepito');
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
    }
    
    function testGetSetUltimoLogin(){
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
        
        $this->usuario->setUltimoLogin('2015-04-19 00:03:59');
        
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), '2015-04-19 00:03:59');
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
    }
    
    function testGetSeLoginEnabled(){
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
        
        $this->usuario->setLoginEnabled(1);
        
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), 1);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
    }
    
    function testGetSeVerificacion(){
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
        
        $this->usuario->setVerificacion('1v');
        
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), '1v');
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
    }
    
    function testGetSetMail(){
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
        
        $this->usuario->setMail('nuevomail@nuevodominio.com');
        
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), 'nuevomail@nuevodominio.com');
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
    }
    
    function testGetSetNombre(){
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
        
        $this->usuario->setNombre('nuevonombre');
        
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), 'nuevonombre');
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
    }
    
    function testGetSetOrden(){
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), $this->datos['orden']);
        
        $this->usuario->setOrden(7);
        
        $this->assertEqual($this->usuario->getId(), $this->datos['id']);
        $this->assertEqual($this->usuario->getUser(), $this->datos['user']);
        $this->assertEqual($this->usuario->getPass(), $this->datos['pass']);
        $this->assertEqual($this->usuario->getUltimoLogin(), $this->datos['ultimoLogin']);
        $this->assertEqual($this->usuario->getLoginEnabled(), $this->datos['loginEnabled']);
        $this->assertEqual($this->usuario->getVerificacion(), $this->datos['verificacion']);
        $this->assertEqual($this->usuario->getMail(), $this->datos['mail']);
        $this->assertEqual($this->usuario->getNombre(), $this->datos['nombre']);
        $this->assertEqual($this->usuario->getOrden(), 7);
    }
    //</editor-fold>Test Getters and Setters
    
    

}
