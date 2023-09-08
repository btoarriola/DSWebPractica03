<html>
    <head>
        <title>Formulario</title>
    </head>
    <body>
        <h2>Formulario</h2>
        <div>
            <form action=insert.php method=POST>
                <table cellpadding="5">
                    <tr>
                        <td>Nombre</td> <td><input type="text" name="nombre" placeholder="Nombre" required/></td>
                    </tr>
                    <tr>
                        <td>Direccion</td> <td><input type="text" name="direccion" placeholder="Direccion" required/></td>
                    </tr>
                    <tr>
                        <td>Telefono</td> <td><input type="number" name="telefono" placeholder="Telefono" required/></td> <td><input type=submit value="Guardar"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div>
            <table cellspacing="5" cellpadding="10">
                <tr style="background-color:#333; color:white;">
                    <th color="white">Clave</th><th>Nombre</th><th>Direccion</th><th>Telefono</th><th>Modificar</th><th>Borrar</th>
                </tr>
                <?php 
                    $user="postgres";
                    $password="pass";
                    $url="pgsql:host=172.17.0.3 port=5432 dbname=mydb";
                    try{
                        $conn = new PDO($url,$user, $password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                        if($conn){
                            $select = $conn->prepare("SELECT * FROM mytable");
                            $select->execute();
                            while ($fila = $select->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr style='background-color:#ccc;'>";
                                echo "  <td>"; echo $fila['clave']; echo "</td>";
                                echo "  <td>"; echo $fila['nombre']; echo "</td>";
                                echo "  <td>"; echo $fila['direccion'];echo "</td>";
                                echo "  <td>"; echo $fila['telefono'];echo "</td>";
                                echo "  <td>";
                                echo '
                                    <details>
                                        <summary>Modificar</summary>
                                        <div id="formupdate">
                                            <form action="update.php" method="post">
                                                <input type="hidden" name="clave" value="'.$fila['clave'].'">
                                                <label for="nombre">Nombre </label>
                                                <input type="text" name="nombre" required/><br>
                                                <label for="direccion">Dirección</label>
                                                <input type="text" name="direccion" required/><br>
                                                <label for="telefono">Telefono</label>
                                                <input type="number" name="telefono" required/><br>
                                                <input type="submit" value="Modificar">
                                            </form>
                                        </div>
                                    </details>
                                ';
                                echo "  </td>";
                                echo "  <td>";
                                echo '
                                    <details>
                                        <summary>Borrar</summary>
                                        <div id="formdelete">
                                            <form action="delete.php" method="post">
                                                <input type="hidden" name="clave" value="'.$fila['clave'].'">
                                                ¿Desea borrar este registro?<br>
                                                <input type="submit" value="Sí, borrar">
                                            </form>
                                        </div>
                                    </details>
                                ';
                                echo "  </td>";
                                echo "</tr>";
                            }
                        }
                    }
                    catch(PDOException $exp){
                        echo("No se pudo conectar a la bd, $exp");
                        die($e->getMessage());
                    } finally{
                        if($conn){
                            $conn=null;
                        }
                    }
                ?>
                 
            </table>
        </div>


    </body>
</html>