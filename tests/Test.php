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

}
