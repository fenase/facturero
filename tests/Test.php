<?php

class TestOfUsuario extends UnitTestCase{
    
    private $usuario;
    private $usuario2;
    private $usuario3;
    private $datos;
    private $datos2;
    private $datos3;
    
    function __construct(){
        $esUnaPruebaEntoncesIgnorarSesiones = TRUE;
        chdir(dirname(dirname(__FILE__)));
        include 'private/prepend.php';
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
        $this->datos2 = array(
            'id'           => 2,
            'user'         => 'fe',
            'pass'         => 'contrase',
            'ultimoLogin'  => '2015-05-01 04:19:59',
            'loginEnabled' => 1,
            'verificacion' => 'verifi',
            'mail'         => 'mail2@server.com',
            'nombre'       => 'este no es mi nombre',
            'orden'        => '2'
        );
        $this->datos3 = array(
            'id'           => 3,
            'user'         => 'fs',
            'pass'         => 'contrasena',
            'ultimoLogin'  => '2015-04-09 07:19:59',
            'loginEnabled' => 0,
            'verificacion' => 'verificame',
            'mail'         => 'mail@otroserver.com',
            'nombre'       => 'este si es mi nombre',
            'orden'        => '4'
        );
        $this->usuario = new Usuario(NULL, USER_MANUAL_DEFINE, $this->datos);
        $this->usuario2 = new Usuario(NULL, USER_MANUAL_DEFINE, $this->datos2);
        $this->usuario3 = new Usuario(NULL, USER_MANUAL_DEFINE, $this->datos3);
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
    
    function testCrearConjunto(){
        $arreglo = array($this->datos, $this->datos2, $this->datos3);
        $usuarios = Usuario::crearUsuarios($arreglo);
        
        $this->assertEqual(count($usuarios), 3);
        $this->assertIdentical($usuarios[0], $this->usuario);
        $this->assertIdentical($usuarios[1], $this->usuario2);
        $this->assertIdentical($usuarios[2], $this->usuario3);
    }
    
    function testSacarHuecosOrden(){
        $arreglo = array($this->datos, $this->datos2, $this->datos3);
        $usuarios = Usuario::crearUsuarios($arreglo);
        $this->assertNotEqual($usuarios[0]->getOrden(), 1);//orden == 9
        Usuario::sacarHuecosOrden($usuarios);
        $this->assertEqual($usuarios[0]->getOrden(), 1);
        $this->assertEqual($usuarios[1]->getOrden(), 2);
        $this->assertEqual($usuarios[2]->getOrden(), 3);
    }
    
    function testCompararOrden(){
        $orden = Usuario::compararOrden($this->usuario2, $this->usuario3);//u2->2; u3->4
        $this->assertEqual($orden, -1);//u2->2 < u3->4
        
        $orden = Usuario::compararOrden($this->usuario3, $this->usuario2);//u3->4, u2->2
        $this->assertEqual($orden, 1);//u3->4 < u2->2
        
        $orden = Usuario::compararOrden($this->usuario2, $this->usuario2);//u2->2, u2->2
        $this->assertEqual($orden, 0);//u2->2 < u2->2
    }

}
