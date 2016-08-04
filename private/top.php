<?php
/**
 * llama a prepend.php y carga el encabezado del sitio
 * @package frontEnd
 */

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'prepend.php');

$topFrame = $twig->loadTemplate('top.twig');

$twigVariables['secciones'] = obtenerSecciones();
