<?php
class TestOfUsuario extends UnitTestCase {
	function __construct() {
		$esUnaPruebaEntoncesIgnorarSesiones = TRUE;
        chdir(dirname(dirname(__FILE__)));
		include 'prepend.php';
    }
	
    function testTrue() {
		$this->assertTrue(TRUE);
	}

}
