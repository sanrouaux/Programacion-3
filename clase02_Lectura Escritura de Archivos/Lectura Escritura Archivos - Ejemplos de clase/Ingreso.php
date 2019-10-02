<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <!--La etiqueta form envía un request al servidor-->
    <!--Cuenta con código encubierto-->
    <!--Entre las etiquetas de apertura y cierre, deben ir los inputs-->
    <!--Requiere de un input tipo submit para enviar la información-->
    <form method="POST" action="Escribir2.php">
        <table>
            <tr>
                <td colspan="2">
                    <input type="textBox" name="nombre"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="textBox" name="apellido"/>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="Enviar"/>
                </td>
                <td>
                    <input type="reset" value="Limpiar"/>
                </td>
            </tr>      
        
        </table>
    </form>
</body>
</html>