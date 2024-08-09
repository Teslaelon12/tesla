<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $telefono = $_POST['telefono'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT id, telefono, contraseña FROM usuarios1 WHERE telefono = '$telefono'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
        if (password_verify($contraseña, $usuario['contraseña'])) {
            $_SESSION['telefono'] = $usuario['telefono'];
            header('Location: usuario.php');
            exit();
        } else {
            echo "Número de teléfono o contraseña incorrectos.";
        }
    } else {
        echo "Número de teléfono o contraseña incorrectos.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('fondo.jpg'); /* Asegúrate de que esta imagen exista en tu directorio */
            background-size: cover;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px; /* Ajusta el ancho según sea necesario */
            width: 100%;
        }
        .container h1 {
            margin-bottom: 20px;
        }
        .container label {
            display: block;
            margin: 10px 0 5px;
        }
        .container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
        }
        .container button {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .container button:hover {
            background-color: #0056b3;
        }
        .container .enlace-inscripcion {
            margin-top: 20px;
            font-size: 16px;
        }
        .container .enlace-inscripcion a {
            color: #007bff;
            text-decoration: none;
        }
        .container .enlace-inscripcion a:hover {
            text-decoration: underline;
        }
        .container .botones {
            margin-top: 20px;
        }
        .container .botones button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .container .botones button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inicio de Sesión</h1>
        <form action="inicio_sesion.php" method="post">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required><br>
            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required><br>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <div class="enlace-inscripcion">
            <p>¿No tienes cuenta? <a href="registro1.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>
