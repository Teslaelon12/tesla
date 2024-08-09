<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['telefono'])) {
    header('Location: inicio_sesion.php'); // Redirigir a la página de inicio de sesión si no hay sesión activa
    exit();
}

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "registro";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el código de referencia del usuario
$telefono = $_SESSION['telefono'];
$sql = "SELECT codigo_referencia FROM usuarios1 WHERE telefono = '$telefono'";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $codigo_referencia = $row['codigo_referencia'];
} else {
    die("Error al obtener el código de referencia del usuario.");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitación</title>
    <style>
        body {
            background: url('fondous.png') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        .form-group button {
            background-color: #008CBA;
            border: none;
            color: white;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        .info {
            margin-top: 20px;
        }
        .info p {
            margin: 0;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 10px 0;
        }
        .footer a {
            text-align: center;
            color: white;
            text-decoration: none;
            font-size: 12px;
        }
        .footer img {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Invita a tus amigos</h2>
        <p>¡Invita a tus amigos a registrarse en nuestra plataforma y obtén beneficios! Comparte el siguiente enlace con tu código de referencia:</p>
        <div class="form-group">
            <input type="text" value="https://tu-sitio.com/registro.php?codigo=<?php echo htmlspecialchars($codigo_referencia); ?>" readonly>
        </div>
        <p><strong>Tu código de referencia:</strong> <?php echo htmlspecialchars($codigo_referencia); ?></p>
    </div>
    <div class="footer">
        <a href="maquina.php">
            <img src="inicio.png" alt="">
            <p>Inicio</p>
        </a>
        <a href="exito.php">
            <img src="ganacia.png" alt="">
            <p>Ganancias</p>
        </a>
        <a href="invitacion.php">
            <img src="compartir.png" alt="">
            <p>Compartir</p>
        </a>
        <a href="usuario.php">
            <img src="mio.png" alt="">
            <p>Mio</p>
        </a>
    </div>
</body>
</html>


