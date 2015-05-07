<?php

$link = require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');



if($_POST['action'] == login){
    $login = $link->escape_string($_POST['usr']);
    $query = "SELECT pass, UNIX_TIMESTAMP(ultimoLogin) as ultimoLogin, loginenabled "
            . "FROM usuarios "
            . "WHERE user = '$login'";
    $res   = $link->query($query);
    if($res->num_rows){
        if(($row = $res->fetch_assoc())){
            $passIngresada = $link->escape_string($_POST['pass']) . $row['ultimoLogin'];
            if(!$row['loginenabled']){
                echo 'USUARIO DESHABILITADO';
            }elseif($row['pass'] != sha1($passIngresada)){
                echo 'PASS INCORRECTO';
            }else{//GUARDA que no controlo errores
                $_SESSION['user'] = $login;
                $link->query("UPDATE usuarios SET ultimoLogin = NOW() WHERE user = '" . $login . "'");
                $res2             = $link->query("SELECT UNIX_TIMESTAMP(ultimoLogin) as ultimoLogin FROM usuarios WHERE user = '" . $login . "'");
                $row2             = $res2->fetch_assoc();
                $nuevaPass        = sha1($link->escape_string($_POST['pass']) . $row2['ultimoLogin']);
                $link->query("UPDATE usuarios SET pass = '$nuevaPass' WHERE user = '" . $login . "'");
                header('location: ./main.php');
            }
        }
    }else{
        echo 'USUARIO INCORRECTO';
    }
}
$contenido = file_get_contents('./template/index.html');
echo $contenido;




