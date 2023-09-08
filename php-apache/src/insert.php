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
            $insert = $conn->prepare("INSERT INTO mytable (nombre, direccion, telefono) VALUES (:nombre, :direccion, :telefono)");
            $insert->bindParam(':nombre', $_POST['nombre']);
            $insert->bindParam(':direccion', $_POST['direccion']);
            $insert->bindParam(':telefono', $_POST['telefono']);

            $insert->execute();
            if($insert){
                echo '<script>alert("Insert bien"); window.location.href = "/index.php";</script>';
            }
            else{
                echo '<script>alert("Insert mal, intente de nuevo"); window.location.href = "/index.php";</script>';
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