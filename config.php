<?php

/* BASE DE DATOS: */
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBDB', 'facturero');

$link = new database(DBHOST, DBUSER, DBPASS, DBDB);

$query = "SELECT llave, valor, type FROM config WHERE 1";
$res   = $link->query($query);
$arreglos = array();
while($row   = $res->fetch_assoc()){
    switch(strtoupper($row['type'])){
        case 'ARRAY':
            $arreglos[$row['llave']][] = $row['valor'];
            break;
        case 'BOOLEAN':
            if(!defined($row['llave'])){
                define($row['llave'],
                       ((strtoupper($row['valor']) == 'TRUE') ? TRUE : FALSE));
            }
            break;
        default:
            if(!defined($row['llave'])){
                define($row['llave'], $row['valor']);
            }
            break;
    }
}

foreach($arreglos as $key => $value){
    if(!defined($key)){
        define($key, serialize($value));
    }
}

return $link;
