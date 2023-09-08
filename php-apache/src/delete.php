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
            $update = $conn->prepare("DELETE FROM mytable WHERE clave = :clave");
            $update->bindParam(':clave', $_POST['clave']);

            $update->execute();
            if($update){
                echo '<script>alert("Se borró"); window.location.href = "/index.php";</script>';
            }
            else{
                echo '<script>alert("Error al borrar, intente de nuevo"); window.location.href = "/index.php";</script>';
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