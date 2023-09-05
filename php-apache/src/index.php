<html>
<body>    
    <?php
    for($i=0; $i<=10; $i++){
        echo'hola mundo<br> ';
    }
    echo "conecxion a PG";
    $user="postgres";
    $password="pass";
    $url="pgsql:host=172.17.0.2 port=5432 dbname=mydb";
    try{
        $conn = new PDO($url,$user, $password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        if($conn){
            $insert = $conn->prepare("INSERT INTO mytable (clave, nombre, direccion) VALUES (:clave, :nombre, :direccion)");
            $insert->bindParam(':clave', $_POST['clave']);
            $insert->bindParam(':nombre', $_POST['nombre']);
            $insert->bindParam(':direccion', $_POST['direccion']);

            $insert->execute();
            if($insert){
                echo "Insert bien";
            }
            else{
                echo "insert mal.";
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