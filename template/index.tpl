<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Administraci&oacute;n del Facturero Baufest</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>Introducir credenciales:
            <form method='POST'>
                <fieldset> <legend>Datos de inicio</legend>
                <input type="hidden" name='action' id='action' value="login">
                USER: <input type="text" name='usr' id='usr'><br>
                PASS: <input type="password" name='pass' id='pass'> <br>
                <input type="submit" value="login"></fieldset>
            </form>
        {{error}}
        </div>
    </body>
</html>