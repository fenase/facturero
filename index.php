<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');



if($_POST['action'] == login){
    $login             = $link->escape_string($_POST['usr']);
    $userIntentaEntrar = new Usuario($login, USER_SEARCH_TIPE_USER);
    //si tengo usuario válido
    if($userIntentaEntrar->getId() !== FALSE){
        $passLimpia    = $link->escape_string($_POST['pass']);
        $passIngresada = $passLimpia . $userIntentaEntrar->getUltimoLoginTimestamp();
        if(!$userIntentaEntrar->getLoginEnabled()){
            echo 'USUARIO DESHABILITADO';
        }elseif($userIntentaEntrar->getPass() != sha1($passIngresada)){
            echo 'PASS INCORRECTO';
        }else{
            //GUARDA que no controlo errores
            $_SESSION['user'] = $login;
            $userIntentaEntrar->setUltimoLoginTimestamp();
            $userIntentaEntrar->setPass(sha1($passLimpia . $userIntentaEntrar->getUltimoLoginTimestamp()));
            $userIntentaEntrar->guardar();
            redirect('./main.php');
        }
    }else{
        echo 'USUARIO INCORRECTO';
    }
}
$contenido = file_get_contents('./template/index.html');
echo $contenido;

