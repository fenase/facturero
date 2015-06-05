<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'prepend.php');

$_SESSION = array();
if(ini_get("session.use_cookies")){
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"],
              $params["domain"], $params["secure"]
    );
}
session_destroy();
redirect('./index.php');
