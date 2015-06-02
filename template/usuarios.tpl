<!DOCTYPE html>
<html>
    <head>
        <title>Vista de usuarios</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <table>
                <tr>
                    <th>
                        user
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        mail
                    </th>
                    <th>
                        ultimo ingreso
                    </th>
                    <th>
                        Acci&oacute;n
                    </th>
                </tr>
                {% for item in usuarios %}
                <tr>
                    <td>
                        {{item.user}}
                    </td>
                    <td>
                        <a href="{{config.BASEURL}}/usuario.php?id={{item.id}}">{{item.nombre}}</a>
                    </td>
                    <td>
                        {{item.mail}}
                    </td>
                    <td>
                        {{item.ultimoLogin}}
                    </td>
                    <td>
                        {{item.accion}}
                    </td>
                </tr>{% endfor %}
            </table>
        </div>
        <div><a href="{{config.BASEURL}}/main.php">Men&uacute; principal</a></div>
        <div><a href="{{config.BASEURL}}/logout.php">salir</a></div>
    </body>
</html>
