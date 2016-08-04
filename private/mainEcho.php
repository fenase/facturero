<?php
/**
 * crea la página a mostrar para todo el sitio
 * @package backEnd
 */

echo $topFrame->render($twigVariables);
echo $template->render($twigVariables);
echo $bottomFrame->render($twigVariables);

