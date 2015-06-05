<?php

define('USER_SEARCH_TIPE_ID', 0);
define('USER_SEARCH_TIPE_USER', 1);
define('USER_MANUAL_DEFINE', 2);

define('FACTURERO_DEBUG_MODE', TRUE);

define('BASEDIR', dirname(dirname(__FILE__)));

define('SECCIONES_POSIBLES',
       serialize(array(
            array(
                'pagina'      => 'index.php',
                'nombre'      => 'ingresar',
                'disabled'    => FALSE,
                'active'      => FALSE,
                'deshabilita' => array(
                    'main.php', 'usuarios.php', 'proyectos.php', 'logout.php'
                ),
            ),
            array(
                'pagina'      => 'main.php',
                'nombre'      => 'Principal',
                'disabled'    => FALSE,
                'active'      => FALSE,
                'deshabilita' => array(
                    'index.php'
                ),
            ),
            array(
                'pagina'      => 'usuarios.php',
                'nombre'      => 'Vista de Usuarios',
                'disabled'    => FALSE,
                'active'      => FALSE,
                'deshabilita' => array(
                    'index.php'
                ),
            ),
            array(
                'pagina'      => 'proyectos.php',
                'nombre'      => 'Vista de proyectos',
                'disabled'    => FALSE,
                'active'      => FALSE,
                'deshabilita' => array(
                    'index.php'
                ),
            ),
            array(
                'pagina'      => 'logout.php',
                'nombre'      => 'Salir',
                'disabled'    => FALSE,
                'active'      => FALSE,
                'deshabilita' => array(
                    'index.php'
                ),
            ),
        ))
);

define('SECCIONES_HIJOS',
    serialize(array(
        'usuarios.php' => array(
            'usuario.php',
        ),
        'proyectos.php' => array(
            'proyecto.php',
        ),
    ))
);
