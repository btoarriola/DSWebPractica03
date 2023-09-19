<?php
session_start();

$url = "pgsql:host=172.17.0.3;port=5432;dbname=mydb;";
try {
    $pdo = new PDO($url, "postgres", "pass", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if (isset($_POST["nombre"]) && isset($_POST["pass"])) {
        $nombre = $_POST["nombre"];
        $pass = $_POST["pass"];
        
        $query = "SELECT * FROM usuario WHERE usuario=:usuario and password=:password";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':usuario', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
        $stmt->execute();
        
        $nr = $stmt->rowCount();
        
        if ($nr == 1) {
            $_SESSION["nombre"] = $nombre;
            header("Location: index.php");
            exit();
        } else {
            header("Location: login.php"); 
            exit();
        }
    }

    if (isset($_SESSION["nombre"])) {
        header("Location: index.php");
        exit();
    }
    //Sign up
    if (isset($_POST["crear_nombre"]) && isset($_POST["crear_pass"])) {
        $nuevo_nombre = $_POST["crear_nombre"];
        $nuevo_pass = $_POST["crear_pass"];
        
        // Insertar el nuevo usuario en la base de datos
        $query = "INSERT INTO usuario (usuario, password) VALUES (:usuario, :password)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':usuario', $nuevo_nombre, PDO::PARAM_STR);
        $stmt->bindParam(':password', $nuevo_pass, PDO::PARAM_STR);
        $stmt->execute();
        
        // Redirigir al usuario a la página de inicio de sesión
        header("Location: login.php");
        exit();
    }

} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Formulario</h1>
    <table>
        <tr><td width="40%">
            <h2>Login</h2>
            <table>
                <form method="post" action="">
                    <tr><td><h3>Nombre</h3></td></tr>
                    <tr><td><input type="text" name="nombre"></td></tr>
                    <tr><td><h3>Constraseña</h3></td></tr>
                    <tr><td><input type="password" name="pass"></td></tr>
                    <tr><td><input type="submit" value="Ingresar"></td></tr>
                </form>
            </table>
        </td>
        <td width="40%">
            <h2>Signup</h2>
            <table>
                <form method="post" action="">
                    <tr><td><h3>Nombre de Usuario</h3></td></tr>
                    <tr><td><input type="text" name="crear_nombre"></td></tr>
                    <tr><td><h3>Contraseña</h3></td></tr>
                    <tr><td><input type="password" name="crear_pass"></td></tr>
                    <tr><td><input type="submit" value="Crear Usuario"></td></tr>
                </form>
            </table>
        </td></tr>
    </table>
</body>
</html>