<?php

$twigVariables['title'] = 'Administración del Facturero Baufest';

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$template      = $twig->loadTemplate('index.twig');
$twigVariables = array();

if($_POST['action'] == login){
    $login             = $link->escape_string($_POST['usr']);
    $userIntentaEntrar = new Usuario($login, USER_SEARCH_TIPE_USER);
    //si tengo usuario válido
    if($userIntentaEntrar->getId() !== FALSE){
        $passLimpia    = $link->escape_string($_POST['pass']);
        $passIngresada = $passLimpia . $userIntentaEntrar->getUltimoLoginTimestamp();
        if(!$userIntentaEntrar->getLoginEnabled()){
            $twigVariables['error'] = 'USUARIO DESHABILITADO';
        }elseif($userIntentaEntrar->getPass() != sha1($passIngresada)){
            $twigVariables['error'] = 'PASS INCORRECTO';
        }else{
            //GUARDA que no controlo errores
            $_SESSION['user']           = $userIntentaEntrar->getUser();
            $_SESSION['userNombreReal'] = $userIntentaEntrar->getNombre();
            $userIntentaEntrar->setUltimoLoginTimestamp();
            $userIntentaEntrar->setPass(sha1($passLimpia . $userIntentaEntrar->getUltimoLoginTimestamp()));
            $userIntentaEntrar->guardar();
            redirect('./main.php');
        }
    }else{
        $twigVariables['error'] = 'USUARIO INCORRECTO';
    }
}

require_once('mainEcho.php');
