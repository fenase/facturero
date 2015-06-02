<!DOCTYPE html>
<html>
    <head>
        <title>Vista de proyectos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <table>
                <tr>
                    <th>
                        Id Proyecto
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Frecuencia
                    </th>
                    <th>
                        Cantidad de participantes
                    </th>
                    <th>
                        Acci&oacute;n
                    </th>
                </tr>
                {% for item in proyectos %}
                <tr>
                    <td>
                        {{item.id}}
                    </td>
                    <td>
                        <a href="{{config.BASEURL}}/proyecto.php?id={{item.id}}">{{item.nombre}}</a>
                    </td>
                    <td>
                        {{item.frecuencia}}
                    </td>
                    <td>
                        {{item.cantidadParticipantes}}
                    </td>
                    <td>
                        {{item.accion}}
                    </td>
                </tr>{% endfor %}
            </table>
        </div>
        <div>
            <a href="{{config.BASEURL}}/main.php">Atr&aacute;s</a>
        </div>
    </body>
</html>
