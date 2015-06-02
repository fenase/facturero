<!DOCTYPE html>
<html>
    <head>
        <title>Vista de usuario: {{usuario.nombre}}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <table>
                <tr>
                    <td>
                        Id Usuario
                    </td>
                    <td>
                        {{usuario.id}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Login
                    </td>
                    <td>
                        {{usuario.user}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre
                    </td>
                    <td>
                        {{usuario.nombre}}
                    </td>
                </tr>
                <tr>
                    <td>
                        &uacute;ltimo Ingreso
                    </td>
                    <td>
                        {{usuario.ultimoLogin}} 
                    </td>
                </tr>
                <tr>
                    <td>
                        Correo
                    </td>
                    <td>
                        {{usuario.mail}}
                    </td>
                </tr>
                <tr>
                    <td>
                        proyectos
                    </td>
                    <td>
                        <ul>
                            {% for proyecto in proyectosUsuario %}
                            <li>
                                <a href="{{config.BASEURL}}/proyecto.php?id={{proyecto.id}}">{{proyecto.nombre}}</a>
                            </li>
                            {% endfor %}
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <div><a href="{{config.BASEURL}}/proyectos.php">Vista de Usuarios</a></div>
        <div><a href="{{config.BASEURL}}/main.php">Men&uacute; principal</a></div>
        <div><a href="{{config.BASEURL}}/logout.php">salir</a></div>
    </body>
</html>
