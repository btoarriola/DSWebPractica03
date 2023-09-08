<html>
<body>    
    <?php
    echo "conecxion a PG";
    $user="postgres";
    $password="pass";
    $url="pgsql:host=172.17.0.3 port=5432 dbname=mydb";
    try{
        $conn = new PDO($url,$user, $password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        if($conn){
            $update = $conn->prepare("UPDATE mytable SET nombre = :nombre, direccion = :direccion, telefono = :telefono WHERE clave = :clave");
            $update->bindParam(':nombre', $_POST['nombre']);
            $update->bindParam(':direccion', $_POST['direccion']);
            $update->bindParam(':telefono', $_POST['telefono']);
            $update->bindParam(':clave', $_POST['clave']);

            $update->execute();
            if($update){
                echo '<script>alert("Se actualizó"); window.location.href = "/index.php";</script>';
            }
            else{
                echo '<script>alert("Error en actualización, intente de nuevo"); window.location.href = "/index.php";</script>';
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
</body>
</html>