<?php

    $case = isset($_GET["instruccion"]) ? $_GET["instruccion"] : null;

    $host = 'localhost';
    $user = "root";
    $password = "";
    $dataBase = "mercado";

    $connection = mysqli_connect($host, $user, $password, $dataBase);
       

    switch($case)
    {
        case "traerTodos_usuarios":
        $sqlInstruction = "SELECT * FROM `usuarios`";
        $result = $connection->query($sqlInstruction);
        $tabla = "<table>
                    <tr>
                        <td>ID</td>
                        <td>NOMBRE</td>
                        <td>APELLIDO</td>
                        <td>PERFIL</td>
                        <td>ESTADO</td>
                    </tr>";
        while($row = $result->fetch_object())
        {         
            $tabla .= "<table>
            <tr>
                <td>".$row->id."</td>
                <td>". $row->nombre ."</td>
                <td>". $row->apellido ."</td>
                <td>". $row->perfil ."</td>
                <td>". $row->estado ."</td>
            </tr>";   
        }
        $tabla .= "</table>";
        echo $tabla;
        break;

        case "traerPorId_usuarios":
        $sqlInstruction = "SELECT * FROM `usuarios` WHERE id=" . $_GET["id"];
        $result = $connection->query($sqlInstruction);
        if($result != null)
        {
            $row = $result->fetch_object();                 
            echo $row->id . " - " . $row->nombre . " - " . $row->apellido . " - " . $row->clave . "<br/>";
        }        
        break;

        case "traerPorEstado_usuarios":
        $sqlInstruction = "SELECT * FROM `usuarios` WHERE estado=" . $_GET["estado"];
        $result = $connection->query($sqlInstruction);
        while($row = $result->fetch_object())        
        {            
            echo $row->id . " - " . $row->nombre . " - " . $row->apellido . " - " . $row->clave . "<br/>";
        }
        break;

        case "agregar_usuarios":
        $sqlInstruction = "INSERT INTO `usuarios`(`nombre`, `apellido`, `clave`, `perfil`, 
            `estado`) VALUES ('" . $_GET["nombre"] . "','" . $_GET["apellido"] . "','"
            . $_GET["clave"] . "','" . $_GET["perfil"] . "','" . $_GET["estado"] . "')";
        $result = $connection->query($sqlInstruction);
        if(mysqli_affected_rows($connection) > 0) {            
            echo "Se agregó un registro";
        }
        else {
            echo "No se agregó el registro";
        }
        break;

        case "modificar_usuarios":
        $sqlInstruction = "UPDATE `usuarios` SET `nombre`='".$_GET["nombre"]."',
        `apellido`='".$_GET["apellido"]."',`clave`='".$_GET["clave"]."',
        `perfil`=".$_GET["perfil"].",`estado`=".$_GET["estado"]." WHERE id=".$_GET["id"];
        $result = $connection->query($sqlInstruction);       
        if(mysqli_affected_rows($connection) > 0)
        {            
            echo "Se modificó un registro";
        }
        else
        {
            echo "No se modificó el registro";
        }
        break;

        case "borrar_usuarios":
            $sqlInstruction = "DELETE FROM `usuarios` WHERE id=".$_GET["id"];
            $result = $connection->query($sqlInstruction);       
            if(mysqli_affected_rows($connection) > 0)
            {            
                echo "Se eliminó un registro";
            }
            else
            {
                echo "No se pudo eliminar al usuario";
            }
            break;
    }