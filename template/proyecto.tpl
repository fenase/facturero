<!DOCTYPE html>
<html>
    <head>
        <title>Vista de proyecto: {{proyecto.nombre}}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <table>
                <tr>
                    <td>
                        Id Proyecto
                    </td>
                    <td>
                        {{proyecto.id}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Nombre
                    </td>
                    <td>
                        {{proyecto.nombre}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Frecuencia
                    </td>
                    <td>
                        {{proyecto.frecuencia}} 
                    </td>
                </tr>
                <tr>
                    <td>
                        Cantidad de participantes
                    </td>
                    <td>
                        {{proyecto.cantidadParticipantes}}
                    </td>
                </tr>
                <tr>
                    <td>
                        comentarios
                    </td>
                    <td>
                        {{proyecto.comentarios}}
                    </td>
                </tr>
                <tr>
                    <td>
                        leyenda
                    </td>
                    <td>
                        {{proyecto.leyenda}}
                    </td>
                </tr>
                <tr>
                    <td>
                        participantes
                    </td>
                    <td>
                        <ul>
                            {% for usuario in proyecto.participantes %}
                            <li>
                                <a href="{{config.BASEURL}}/usuario.php?id={{usuario.id}}">{{usuario.nombre}}</a>
                            </li>
                            {% endfor %}
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <div><a href="{{config.BASEURL}}/proyectos.php">Vista de proyectos</a></div>
        <div><a href="{{config.BASEURL}}/main.php">Men&uacute; principal</a></div>
        <div><a href="{{config.BASEURL}}/logout.php">salir</a></div>
    </body>
</html>
