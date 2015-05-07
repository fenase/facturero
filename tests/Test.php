<?php

class TestOfUsuario extends UnitTestCase{

    function __construct(){
        $esUnaPruebaEntoncesIgnorarSesiones = TRUE;
        chdir(dirname(dirname(__FILE__)));
        include 'prepend.php';
    }

    function test_constructFromData(){
        $datos   = array(
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
        $usuario = new usuario(NULL, USER_MANUAL_DEFINE, $datos);
        
        $this->assertEqual($usuario->getId(), $datos['id']);
        $this->assertEqual($usuario->getUser(), $datos['user']);
        $this->assertEqual($usuario->getPass(), $datos['pass']);
        $this->assertEqual($usuario->getUltimoLogin(), $datos['ultimoLogin']);
        $this->assertEqual($usuario->getLoginEnabled(), $datos['loginEnabled']);
        $this->assertEqual($usuario->getVerificacion(), $datos['verificacion']);
        $this->assertEqual($usuario->getMail(), $datos['mail']);
        $this->assertEqual($usuario->getNombre(), $datos['nombre']);
        $this->assertEqual($usuario->getOrden(), $datos['orden']);
    }

}
